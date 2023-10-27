<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\CentralLogics\Helpers;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Zone;
use App\Models\Store;
use App\CentralLogics\StoreLogic;
use App\Models\Admin;
use App\Models\Translation;
use App\Models\Vacancy;
use App\Models\VendorEmployee;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Exception;

class VendorLoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $vendor_type= $request->vendor_type;

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if($vendor_type == 'owner'){
            if (auth('vendor')->attempt($data)) {
                $token = $this->genarate_token($request['email']);
                $vendor = Vendor::where(['email' => $request['email']])->first();
                if(!$vendor->stores[0]->status)
                {
                    return response()->json([
                        'errors' => [
                            ['code' => 'auth-002', 'message' => translate('messages.inactive_vendor_warning')]
                        ]
                    ], 403);
                }
                $vendor->auth_token = $token;
                $vendor->save();
                return response()->json(['token' => $token, 'zone_wise_topic'=> $vendor->stores[0]->zone->store_wise_topic], 200);
            }  else {
                $errors = [];
                array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.']);
                return response()->json([
                    'errors' => $errors
                ], 401);
            }
        }elseif($vendor_type == 'employee'){

            if (auth('vendor_employee')->attempt($data)) {
                $token = $this->genarate_token($request['email']);
                $vendor = VendorEmployee::where(['email' => $request['email']])->first();
                if($vendor->store->status == 0)
                {
                    return response()->json([
                        'errors' => [
                            ['code' => 'auth-002', 'message' => translate('messages.inactive_vendor_warning')]
                        ]
                    ], 403);
                }
                $vendor->auth_token = $token;
                $vendor->save();
                $role = $vendor->role ? json_decode($vendor->role->modules):[];
                return response()->json(['token' => $token, 'zone_wise_topic'=> $vendor->store->zone->store_wise_topic, 'role'=>$role], 200);
            } else {
                $errors = [];
                array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.']);
                return response()->json([
                    'errors' => $errors
                ], 401);
            }
        } else {
            $errors = [];
            array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.']);
            return response()->json([
                'errors' => $errors
            ], 401);
        }

    }

    private function genarate_token($email)
    {
        $token = Str::random(120);
        $is_available = Vendor::where('auth_token', $token)->where('email', '!=', $email)->count();
        if($is_available)
        {
            $this->genarate_token($email);
        }
        return $token;
    }

    public function register(Request $request)
    {
        $status = BusinessSetting::where('key', 'toggle_store_registration')->first();
        if(!isset($status) || $status->value == '0')
        {
            return response()->json(['errors' => Helpers::error_processor('self-registration', translate('messages.store_self_registration_disabled'))]);
        }

        $validator = Validator::make($request->all(), [
            'f_name' => 'required|max:100',
            'l_name' => 'nullable|max:100',
            // 'name' => 'required|max:191',
            // 'address' => 'required|max:1000',
            // 'latitude' => 'required',
            // 'longitude' => 'required',
            'email' => 'required|unique:vendors',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:vendors',
            // 'minimum_delivery_time' => 'required',
            // 'maximum_delivery_time' => 'required',
            // 'delivery_time_type'=>'required',
            // 'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            // 'zone_id' => 'required',
            // 'module_id' => 'required',
            'logo' => 'required',
            // 'tax' => 'required'
        ]);

        // if($request->zone_id)
        // {
        //     $zone = Zone::query()
        //     ->whereContains('coordinates', new Point($request->latitude, $request->longitude, POINT_SRID))
        //     ->where('id',$request->zone_id)
        //     ->first();
        //     if(!$zone){
        //         $validator->getMessageBag()->add('latitude', translate('messages.coordinates_out_of_zone'));
        //         return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        //     }
        // }

        $data = json_decode($request->translations, true);

        if (count($data) < 1) {
            $validator->getMessageBag()->add('translations', translate('messages.Name and description in english is required'));
        }

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $vendor = new Vendor();
        $vendor->f_name = $request->f_name;
        $vendor->l_name = $request->l_name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->password = bcrypt($request->password);
        $vendor->status = null;
        $vendor->save();

        $store = new Store;
        $store->name = $data[0]['value'];
        $store->phone = $request->phone;
        $store->email = $request->email;
        $store->city_id = $request->city_id;
        $store->area_id = $request->area_id;
        $store->store_category = 0;
        $store->logo = Helpers::upload('store/', 'png', $request->file('logo'));
        $store->cover_photo = Helpers::upload('store/cover/', 'png', $request->file('cover_photo'));
        $store->address = $data[1]['value'];
        // $store->latitude = $request->latitude;
        // $store->longitude = $request->longitude;
        $store->vendor_id = $vendor->id;
        // $store->zone_id = $request->zone_id;
        // $store->tax = $request->tax;
        // $store->delivery_time = $request->minimum_delivery_time .'-'. $request->maximum_delivery_time.' '.$request->delivery_time_type;
        // $store->module_id = $request->module_id;
        $store->status = 0;
        $store->save();
        // $store->module->increment('stores_count');
        // if(config('module.'.$store->module->module_type)['always_open'])
        // {
        //     StoreLogic::insert_schedule($store->id);
        // }

        foreach ($data as $key=>$i) {
            $data[$key]['translationable_type'] = 'App\Models\Store';
            $data[$key]['translationable_id'] = $store->id;
        }
        Translation::insert($data);

        try{
            $admin= Admin::where('role_id', 1)->first();
            $mail_status = Helpers::get_mail_status('registration_mail_status_store');
            if(config('mail.status') && $mail_status == '1'){
                Mail::to($request['email'])->send(new \App\Mail\VendorSelfRegistration('pending', $vendor->f_name.' '.$vendor->l_name));
            }
            $mail_status = Helpers::get_mail_status('store_registration_mail_status_admin');
            if(config('mail.status') && $mail_status == '1'){
                Mail::to($admin['email'])->send(new \App\Mail\StoreRegistration('pending', $vendor->f_name.' '.$vendor->l_name));
            }
        }catch(\Exception $ex){
            info($ex->getMessage());
        }

        return response()->json(['message'=>translate('messages.application_placed_successfully')],200);
    }


    // api functions for business registration

    // public function businessList(){
    //     $businessList = Store::all();
    //     return response()->json($businessList, 200);
    // }

    public function businessList($id){
        if($id){
            $businessList = Store::selectRaw('*, name as storeName')->where('vendor_id',$id)->get();

            if(count($businessList) > 0){
                 $businessListWithImages = $businessList->map(function ($business) {
                    // $business->offer_image =   'public/images/business-images/' . $business->offer_image;
                    // $business->storeImage = 'public/images/business-images/' . $business->logo;
                    // $business->cover_photo = 'public/images/business-images/' . $business->cover_photo;

                    // $fieldsToUpdate = ['offer_image', 'logo', 'cover_photo'];
                    // foreach ($fieldsToUpdate as $field) {
                    //     $fieldName = ($field === 'logo') ? 'storeImage' : $field;
                    //     if($business->$field){
                    //         $business->$fieldName = 'public/images/business-images/' . $business->$field;
                    //     }else{
                    //          $business->$fieldName = null;
                    //     }
                    // }
                    $fieldsToUpdate = ['offer_image', 'logo', 'cover_photo'];
                    foreach ($fieldsToUpdate as $field) {
                        $fieldName = ($field === 'logo') ? 'storeImage' : $field;
                        $path = ($field === 'logo') ? asset('storage/app/public/store/') : asset('storage/app/public/store/cover');
                        if($business->$field){
                            $business->$fieldName = $path  . $business->$field;
                        }else{
                             $business->$fieldName = null;
                        }
                    }
                    if($business->status ==1){
                       $business->statusName = 'Approved' ;
                    }else{
                        $business->statusName = 'In Review';
                    }
                    // $business->storeName = $business->name;
                    $business->storeDescription = $business->meta_description;
                    $business->createdDate = $business->created_at->format('H:i:s d-m-Y');
                    $business->statusId = $business->status;
                    $business->isActive = $business->active;
                    return $business;
                });
                return response()->json($businessListWithImages, 200);
            }else{
                return response()->json($businessListWithImages = [], 200);
                // return response()->json(['status' => 'error','message' => 'Stores not found on your account'], 200);
            }
        }

    }
    public function saveBusiness(Request $request){
        try {
            if($request->store_id){
                $store_id = $request->store_id;
                $validator = Validator::make($request->all(), [
                    'store_name' => 'required|string|max:255',
                    'description' => 'required',
                    'city_id' => 'required',
                    'area_id' => 'required',
                    'category' => 'required',
                    'store_address' => 'required|string',
                    // 'gmpLink' => 'required',
                    // 'website' => 'required',
                    'f_name' => 'required|string|max:255',
                    // 'phone' => 'required|unique:stores,phone,' . $store_id,
                    'phone' => 'required',
                    'email' => 'required|email',
                    'discPer' => 'required|numeric',
                    'discDesc' => 'required',
                    'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'cover_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'offer_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => Helpers::error_processor($validator)], 403);
                }
                $listing = Store::find($store_id);
                $message = 'Store updated successfully';
            }
            else{
                $existingListing = Store::where('vendor_id', $request->user_id)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();

                if ($existingListing) {
                    return response()->json(['status' => 'error', 'message' => 'You can only add one Store per day.'], 403);
                }

                $validator = Validator::make($request->all(), [
                    'store_name' => 'required|string|max:255',
                    'description' => 'required',
                    'city_id' => 'required',
                    'area_id' => 'required',
                    'category' => 'required',
                    'store_address' => 'required|string',
                    'f_name' => 'required|string|max:255',
                    // 'phone' => 'required|unique:stores,phone',
                    'email' => 'required|email',
                    // 'gmpLink' => 'required',
                    // 'website' => 'required',
                    'phone' => 'required',
                    'discPer' => 'required|numeric',
                    'discDesc' => 'required',
                    'offer_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => Helpers::error_processor($validator)], 403);
                }
                $listing = new Store;
                $message = 'Store Added successfully';
            }
            $listing->name = $request->store_name;
            $listing->phone  = $request->phone;
            $listing->email = $request->email;
            if ($request->hasFile('offer_photo')) {
                if($listing->offer_image){
                    // $filePath = public_path('images/business-images/'.$listing->offer_image) ;
                    // if (file_exists($filePath)) {
                    //     unlink($filePath);
                    // }
                    if (Storage::disk('public')->exists('store/cover/' . $listing->offer_image)) {
                        Storage::disk('public')->delete('store/cover/' . $listing->offer_image);
                    }
                }
                // $imageName = time().'.offer_image.'.$request->offer_photo->extension();
                // $request->offer_photo->move(public_path('images/business-images'), $imageName);
                // $listing->offer_image = $imageName;
                $dir = 'store/cover/';
                $image = $request->file('offer_photo');
                $imageName = time().'.offer_image.'.$request->offer_photo->extension();
                if (!Storage::disk('public')->exists('store/cover/')) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->putFileAs($dir, $image, $imageName);
                $listing->offer_image = $imageName;
            }
            if ($request->hasFile('logo')) {
                if($listing->logo){
                    // $filePath = public_path('images/business-images/'.$listing->logo) ;
                    // if (file_exists($filePath)) {
                    //     unlink($filePath);
                    // }
                    if (Storage::disk('public')->exists('store/' . $listing->logo)) {
                        Storage::disk('public')->delete('store/' . $listing->logo);
                    }
                }

                $imageName = time().'.store_logo.'.$request->logo->extension();
                // $request->logo->move(public_path('images/business-images'), $imageName);
                // $listing->logo = $imageName;
                $dir = 'store/';
                $image = $request->file('logo');
                if (!Storage::disk('public')->exists('store/')) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->putFileAs($dir, $image, $imageName);
                $listing->logo = $imageName;
            }
            if ($request->hasFile('cover_photo')) {
                if($listing->cover_photo){
                    // $filePath = public_path('images/business-images/'.$listing->cover_photo) ;
                    // if (file_exists($filePath)) {
                    //     unlink($filePath);
                    // }
                    if (Storage::disk('public')->exists('store/cover/' . $listing->cover_photo)) {
                        Storage::disk('public')->delete('store/cover/' . $listing->cover_photo);
                    }
                }
                $imageName = time().'.store_banner.'.$request->cover_photo->extension();
                // $request->cover_photo->move(public_path('images/business-images'), $imageName);
                // $listing->cover_photo = $imageName;
                $dir = 'store/cover/';
                $image = $request->file('cover_photo');
                if (!Storage::disk('public')->exists('store/cover/')) {
                    Storage::disk('public')->makeDirectory($dir);
                }
                Storage::disk('public')->putFileAs($dir, $image, $imageName);
                $listing->cover_photo = $imageName;
            }
            $listing->vendor_id =$request->user_id ?? 1;
            $listing->meta_description = $request->description;
            $listing->city_id = $request->city_id;
            $listing->area_id = $request->area_id;
            $listing->store_category = $request->category;
            $listing->owner_name = $request->f_name;
            $listing->offer_percentage = $request->discPer;
            $listing->offer_description = $request->discDesc;
            $listing->map_location_link = $request->gmpLink;
            $listing->website_link = $request->website;
            $listing->store_address = $request->store_address;
            $listing->address = $request->store_address;
            $listing->latitude = '12.918804202266855';
            $listing->longitude = '77.65186298277348';
            $listing->module_id = $request->category;
            $listing->zone_id = 2;
            $listing->active = $request->active ?? 0;
            $listing->status = 0;
            $listing->save();
            if(!$request->store_id){
                $listing->index = $listing->id;
                $listing->save();
            }

            // // Save store schedules
            // $schedules = $requestschedules;
            // if($schedules){
            //     foreach ($schedules as $schedule) {
            //         $store_id = $listing->id;
            //         $day_id = $schedule['day_id'];
            //         $starting_time = $schedule['starting_time'];
            //         $ending_time = $schedule['ending_time'];

            //         StoreSchedule::updateOrCreate(
            //             ['store_id' => $store_id, 'day_id' => $day_id],
            //             ['starting_time' => $starting_time, 'ending_time' => $ending_time]
            //         );
            //     }
            // }

            // front end format should be
            // [
            //     {
            //         "day_id": 1,
            //         "starting_time": "09:00",
            //         "ending_time": "18:00"
            //     },
            //     {
            //         "day_id": 2,
            //         "starting_time": "10:00",
            //         "ending_time": "19:00"
            //     },

            // ]


          return response()->json(['status' => 'success', 'message' => $message], 200);
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to save/store business'], 500);
        }
    }

    public function editBusiness($store_id){
        try {
            $store = Store::find($store_id);
            if($store){
                // $store->offer_image =   'public/images/business-images/' . $store->offer_image;
                // $store->logo = 'public/images/business-images/' . $store->logo;
                // $store->cover_photo = 'public/images/business-images/' . $store->cover_photo;
                $store->offer_image = asset('storage/app/public/store/cover/'.$store->offer_image);
                $store->logo =  asset('storage/app/public/store/'.$store->logo);
                $store->cover_photo = asset('storage/app/public/store/cover/'.$store->cover_photo);
            }
            if (!$store) {
                return response()->json(['status' => 'error','message' => 'Store not found'], 200);
            }
            return response()->json(['status' => 'success', 'data' => $store], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ], 500);
        }

    }


    // api functions for job vacancies
    public function saveVacancy(Request $request){
        try {
            if($request->id){
                $vacancy_id = $request->id;
                $validator = Validator::make($request->all(), [
                    'companyName' => 'required|string|max:255',
                    'jobTitle' => 'required|string|max:255',
                    'jobDescription' => 'required|string',
                    // 'designation' => 'required|string',
                    'minSalary' => 'required|integer|min:0',
                    // 'maxSalary' => 'required|integer|min:0',
                    'location' => 'required|string|max:255',
                    'education' => 'required|string|max:255',
                     'experience' => 'numeric',
                    'contactPerson' => 'required|string|max:255',
                    'contactNumber' => 'required|string|max:255',
                    // 'email' => 'required|email',
                     'website' => 'nullable',
                    'jobType' => 'required',
                    'jobShift' => 'required',
                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => Helpers::error_processor($validator)], 403);
                }
                $listing = Vacancy::find($vacancy_id);
                $message = 'Job Vacancy updated successfully';
            }
            else{
                $existingListing = Vacancy::where('user_id', $request->userId)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();

                if ($existingListing) {
                    return response()->json(['status' => 'error', 'message' => 'You can only add one Job Vacancy per day.'], 403);
                }
                $validator = Validator::make($request->all(), [
                    'companyName' => 'required|string|max:255',
                    'jobTitle' => 'required|string|max:255',
                    'jobDescription' => 'required|string',
                    // 'designation' => 'required|string',
                    'minSalary' => 'required|integer|min:0',
                    // 'maxSalary' => 'required|integer|min:0',
                    'location' => 'required|string|max:255',
                    'education' => 'required|string|max:255',
                    'experience' => 'numeric',
                    'contactPerson' => 'required|string|max:255',
                    'contactNumber' => 'required|string|max:255',
                    // 'email' => 'required|email',
                    'website' => 'nullable',
                    'jobType' => 'required',
                    'jobShift' => 'required',
                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => Helpers::error_processor($validator)], 403);
                }
                $listing = new Vacancy;
                $message = 'Vacancy Added successfully';
            }

            $listing->user_id = $request->userId;
            $listing->company_name = $request->companyName;
            $listing->job_title = $request->jobTitle;
            $listing->job_description = $request->jobDescription;
            $listing->designation = $request->designation;
            $listing->salary_min = $request->minSalary;
            $listing->salary_max = $request->maxSalary;
            $listing->location = $request->location;
            $listing->min_education = $request->education;
            $listing->experience = $request->experience;
            $listing->contact_person_name = $request->contactPerson;
            $listing->contact_no = $request->contactNumber;
            $listing->contact_email = $request->email;
            $listing->website = $request->website;
            $listing->job_type = $request->jobType;
            $listing->shift = $request->jobShift;
            $listing->status = 0;
            $listing->module_id = 10;
            $listing->is_active = $request->active ?? 0;
            if ($request->hasFile('logo')) {
                if($listing->logo){
                    $filePath = public_path('images/post-images/'.$listing->logo) ;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                $imageName = time().'.job_logo.'.$request->logo->extension();
                $request->logo->move(public_path('images/post-images'), $imageName);
                $listing->logo = $imageName;
            }
            $listing->save();
            if(!$request->id){
                $listing->index =  $listing->id;
                $listing->save();
            }
            return response()->json(['status' => 'success', 'message' => $message], 200);
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to save/Job Vacancy Post'], 500);
        }
    }


    public function vacancyList(Request $request,$user_id = null){
        if($user_id){
            $posts = Vacancy::where('user_id', $user_id)->get();
        }elseif($user_id==null || $user_id == '0'){
            $posts = Vacancy::where('status',1)->get();
        }
        if(count($posts) > 0){
                $postsWithImages = $posts->map(function ($post) {
                    $post->createdDate =  $post->created_at->format('H:i:s d-m-Y');
                    if($post->status ==1){
                       $post->statusName = 'Approved' ;
                    }else{
                        $post->statusName = 'In Review';
                    }
                    $post->module_id = 10;
                    return $post;
                });
               return response()->json($postsWithImages, 200);
        }else{
            return response()->json($postsWithImages = [], 200);
            // return response()->json(['status' => 'error','message' => 'Vacancies not found on your account'], 200);
        }
    }

    public function editVacancy($vacancy_id){
        try {
            $vacancy = Vacancy::find($vacancy_id);
            if (!$vacancy) {
                return response()->json(['status' => 'error','message' => 'Job Vacancy Post  not found'], 200);
            }
            return response()->json(['status' => 'success', 'data' => $vacancy], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ], 500);
        }

    }

    // get banners by module Id
    public function getBannerByModuleId($module_id){
        if($module_id){
            $banners = Banner::where('module_id',$module_id)->get();
            if(count($banners) >0){
                return response()->json(['status' => 'success', 'data' => $banners], 200);
            }else{
                return response()->json(['status' => 'error','message' => 'Banners  not found'], 200);
            }
        }else{
            return response()->json(['status' => 'error','message' => 'Banners  not found'], 200);
        }
    }
}
