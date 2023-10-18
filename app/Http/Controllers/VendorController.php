<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Store;
use App\Models\Module;
use App\Models\Vendor;
use App\Models\Post;
use App\Models\Vacancy;
use App\Models\Amenity;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\Models\BusinessSetting;
use App\CentralLogics\StoreLogic;
use App\Models\Admin;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;
use Gregwar\Captcha\CaptchaBuilder;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class VendorController extends Controller
{
    public function create()
    {
        $status = BusinessSetting::where('key', 'toggle_store_registration')->first();
        if(!isset($status) || $status->value == '0')
        {
            Toastr::error(translate('messages.not_found'));
            return back();
        }
        $custome_recaptcha = new CaptchaBuilder;
        $custome_recaptcha->build();
        Session::put('six_captcha', $custome_recaptcha->getPhrase());
        
        return view('vendor-views.auth.register', compact('custome_recaptcha'));
    }

    public function store(Request $request)
    {
        $status = BusinessSetting::where('key', 'toggle_store_registration')->first();
        if(!isset($status) || $status->value == '0')
        {
            Toastr::error(translate('messages.not_found'));
            return back();
        }

        $recaptcha = Helpers::get_business_settings('recaptcha');
        if (isset($recaptcha) && $recaptcha['status'] == 1) {
            $request->validate([
                'g-recaptcha-response' => [
                    function ($attribute, $value, $fail) {
                        $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
                        $response = $value;
                        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
                        $response = Http::get($url);
                        $response = $response->json();
                        if (!isset($response['success']) || !$response['success']) {
                            $fail(translate('messages.ReCAPTCHA Failed'));
                        }
                    },
                ],
            ]);
        } else if(strtolower(session('six_captcha')) != strtolower($request->custome_recaptcha))
        {
            Toastr::error(translate('messages.ReCAPTCHA Failed'));
            return back();
        }

        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'email' => 'required|unique:vendors',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:vendors',
            'minimum_delivery_time' => 'required',
            'maximum_delivery_time' => 'required',
            'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'zone_id' => 'required',
            'module_id' => 'required',
            'logo' => 'required',
            'tax' => 'required',
            'delivery_time_type'=>'required',
        ]);

        if($request->zone_id)
        {
            $zone = Zone::query()
            ->whereContains('coordinates', new Point($request->latitude, $request->longitude, POINT_SRID))
            ->where('id',$request->zone_id)
            ->first();
            if(!$zone){
                $validator->getMessageBag()->add('latitude', translate('messages.coordinates_out_of_zone'));
                return back()->withErrors($validator)
                        ->withInput();
            }
        }
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
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
        $store->name =  $request->name[array_search('default', $request->lang)];
        $store->phone = $request->phone;
        $store->email = $request->email;
        $store->logo = Helpers::upload('store/', 'png', $request->file('logo'));
        $store->cover_photo = Helpers::upload('store/cover/', 'png', $request->file('cover_photo'));
        $store->address = $request->address[array_search('default', $request->lang)];
        $store->latitude = $request->latitude;
        $store->longitude = $request->longitude;
        $store->vendor_id = $vendor->id;
        $store->zone_id = $request->zone_id;
        $store->module_id = $request->module_id;
        $store->tax = $request->tax;
        $store->delivery_time = $request->minimum_delivery_time .'-'. $request->maximum_delivery_time.' '.$request->delivery_time_type;
        $store->status = 0;
        $store->save();

        $default_lang = str_replace('_', '-', app()->getLocale());
            $data = [];
            foreach ($request->lang as $index => $key) {
                if($default_lang == $key && !($request->name[$index])){
                    if ($key != 'default') {
                        array_push($data, array(
                            'translationable_type' => 'App\Models\Store',
                            'translationable_id' => $store->id,
                            'locale' => $key,
                            'key' => 'name',
                            'value' => $store->name,
                        ));
                    }
                }else{
                    if ($request->name[$index] && $key != 'default') {
                        array_push($data, array(
                            'translationable_type' => 'App\Models\Store',
                            'translationable_id' => $store->id,
                            'locale' => $key,
                            'key' => 'name',
                            'value' => $request->name[$index],
                        ));
                    }
                }
                if($default_lang == $key && !($request->address[$index])){
                    if ($key != 'default') {
                        array_push($data, array(
                            'translationable_type' => 'App\Models\Store',
                            'translationable_id' => $store->id,
                            'locale' => $key,
                            'key' => 'address',
                            'value' => $store->address,
                        ));
                    }
                }else{
                    if ($request->address[$index] && $key != 'default') {
                        array_push($data, array(
                            'translationable_type' => 'App\Models\Store',
                            'translationable_id' => $store->id,
                            'locale' => $key,
                            'key' => 'address',
                            'value' => $request->address[$index],
                        ));
                    }
                }
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


        if(config('module.'.$store->module->module_type)['always_open'])
        {
            StoreLogic::insert_schedule($store->id);
        }
        Toastr::success(translate('messages.application_placed_successfully'));
        return back();
    }

    public function get_all_modules(Request $request){
        $module_data = Module::whereHas('zones', function($query)use ($request){
            $query->where('zone_id', $request->zone_id);
        })->notParcel()
        ->where('modules.module_name', 'like', '%'.$request->q.'%')
        ->limit(8)->get([DB::raw('modules.id as id, modules.module_name as text')]);
        return response()->json($module_data);
    }

    // admin  web for posts, stores , vacancies
    public function postsList(){
        $posts = Post::all();
        $activePosts = Post::where('is_active',1)->count();
        $inActivePosts = Post::where('is_active',0)->count();
        $currentDate = Carbon::now();
        $startOfWeek = $currentDate->startOfWeek();
        $postsThisWeek = Post::where('created_at','>=',$startOfWeek)->count();
        return view('admin-views.posts.posts-list', get_defined_vars());
    }

    public function postedit(){
        $posts = Post::all();
        return view('admin-views.posts.post-edit', get_defined_vars());
    }

    public function postview($id){
        $post = Post::findOrFail($id);
        $amenities = Amenity::where('parent_id',1)->get();
        $amenityIdsString = $post->amenities;
        if($post->amenities){
            $amenityIdArray = explode(',',  trim($amenityIdsString,'"'));
        }else{
            $amenityIdArray = '';
        }
        return view('admin-views.posts.post-view', get_defined_vars());
    }


    
    public function changeStatus(Request $request,$store,$status)
    {
        $store = Post::findOrFail($store);
        $store->status = $status;
        $store->save();
        Toastr::success(translate('messages.post_status_updated'));
        return redirect(url('admin/posts/list'));
    }

    public function changeActive(Request $request,$store,$active)
    {
        $store = Post::findOrFail($store);
        $store->is_active = $active;
        $store->save();
        Toastr::success(translate('messages.post_activity_updated'));
        return redirect(url('admin/posts/list'));
    }


    //*******************  functions for jobs********************//

    public function jobsList(){
        $posts = Vacancy::all();
        $activePosts = Vacancy::where('is_active',1)->count();
        $inActivePosts = Vacancy::where('is_active',0)->count();
        $currentDate = Carbon::now();
        $startOfWeek = $currentDate->startOfWeek();
        $postsThisWeek = Vacancy::where('created_at','>=',$startOfWeek)->count();
        return view('admin-views.jobs.jobs-list', get_defined_vars());
    }
    public function jobedit(){
        $posts = Vacancy::all();
        return view('admin-views.jobs.job-edit', get_defined_vars());
    }

    public function jobview($id){
        $posts = Vacancy::find($id);
        return view('admin-views.jobs.job-view', get_defined_vars());
    }
    public function changeJobStatus(Request $request,$store,$status)
    {
        $store = Vacancy::findOrFail($store);
        $store->status = $status;
        $store->save();
        Toastr::success(translate('messages.post_status_updated'));
        return redirect(url('admin/jobs/list'));
    }

    public function changeJobActive(Request $request,$store,$active)
    {
        $store = Vacancy::findOrFail($store);
        $store->is_active = $active;
        $store->save();
        Toastr::success(translate('messages.post_activity_updated'));
        return redirect(url('admin/jobs/list'));
    }
    

}
