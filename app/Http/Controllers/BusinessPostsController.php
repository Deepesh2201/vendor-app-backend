<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Amenity;
use App\Models\Post;
use App\Models\Store;
use App\Models\cities;
use App\Models\Category;
use App\Models\areas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;
class BusinessPostsController extends Controller
{
    public function index(Request $request){

        $posts = Post::where('user_id', 2)->get();
        // $posts = Post::where('user_id', $request->userid);
        return view('admin-views.customer.posts.post_list',get_defined_vars());
    }
    public function create(Request $request){
        $amenities = Amenity::where('parent_id',1)->get();
        return view('admin-views.customer.posts.post_create',get_defined_vars());
    }
    public function savePost(Request $request){

        try {
            if($request->id){

                $request->validate([
                    'title' => 'required|string|max:255',
                    'address' => 'required|string|max:255',
                    'rent_per_month' => 'required|numeric|min:0',
                    'deposit' => 'required|numeric|min:0',
                    'bedrooms' => 'required|integer|min:0',
                    'bathrooms' => 'required|integer|min:0',
                    'floors' => 'required|integer|min:0',
                    'description' => 'required|string',
                    'possession_date' => 'required|date', // Ensure that possession_date is a valid date
                    'image1' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validating image1 as an example, you can apply similar rules to other images
                    'image2' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image fields
                    'image3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image4' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    // 'amenities' => 'required',
                ]);
                $listing = Post::find($request->id);
                $message = 'Post updated successfully';
            }
            else{

                $request->validate([
                    'title' => 'required|string|max:255',
                    'address' => 'required|string|max:255',
                    'rent_per_month' => 'required|numeric|min:0',
                    'deposit' => 'required|numeric|min:0',
                    'bedrooms' => 'required|integer|min:0',
                    'bathrooms' => 'required|integer|min:0',
                    'floors' => 'required|integer|min:0',
                    'description' => 'required|string',
                    'possession_date' => 'required|date', // Ensure that possession_date is a valid date
                    // 'image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validating image1 as an example, you can apply similar rules to other images
                    'image2' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image fields
                    'image3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image4' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    // 'amenities' => 'required',
                ]);
                $listing = new Post();
                $message = 'Post Added successfully';
            }




            // $listing->user_id = auth()->user()->id ?? 0;
            $listing->user_id = 2;
            $listing->title = $request->title;
            $listing->address = $request->address;
            $listing->rent_per_month = $request->rent_per_month;
            $listing->deposit = $request->deposit;
            $listing->bedrooms = $request->bedrooms;
            $listing->bathrooms = $request->bathrooms;
            $listing->floors = $request->floors;
            $listing->description = $request->description;
            $listing->possession_date = $request->possession_date;

            // Handle image uploads
            if ($request->hasFile('image1')) {
                $imageName = time().'.img1-'.$request->image1->extension();
                $request->image1->move(public_path('images/post-images'), $imageName);
                $listing->image1 = $imageName;
            }
            if ($request->hasFile('image2')) {
                $imageName = time().'.img2-'.$request->image2->extension();
                $request->image2->move(public_path('images/post-images'), $imageName);
                $listing->image2 = $imageName;
            }
            if ($request->hasFile('image3')) {
                $imageName = time().'.img3-'.$request->image3->extension();
                $request->image3->move(public_path('images/post-images'), $imageName);
                $listing->image3 = $imageName;
            }
            if ($request->hasFile('image4')) {
                $imageName = time().'.img4-'.$request->image4->extension();
                $request->image4->move(public_path('images/post-images'), $imageName);
                $listing->image4 = $imageName;
            }
            $listing->amenities = json_encode($request->amenities);
            $listing->post_type = 1;
            $listing->save();
            // Toastr::success('Post Added successfully');
            return back()->with('success',$message);
        } catch (ValidationException $e) {
            return redirect()->back()->with(['errors' => $e->errors()]);
        }
    }
    public function editPost($id){
        $amenities = Amenity::where('parent_id',1)->get();
        $post = Post::select('*')->where('id',$id)->first();
        // Remove square brackets and double quotes
        $amenitiesString = str_replace(['[', ']', '"'], '', $post->amenities);
        $amenitiesArray = explode(',', $amenitiesString);
        // dd($amenitiesArray);
        return view('admin-views.customer.posts.post_update',compact('post','amenities','amenitiesArray'));
    }

    // operations related to business stores

    public function getAreasByCity($city_id){
        $areas = areas::where('city_id',$city_id)->where('status',1)->get();
        return response()->json($areas);
    }

    public function createBusiness(){
        $cities = cities::where('status',1)->get();
        $areas = areas::where('status',1)->get();
        $categories = Category::where('parent_id',0)->where('status',1)->get();
        return view('admin-views.customer.business.create-business',get_defined_vars());
    }

    public function saveBusiness(Request $request){
        try {
            if($request->store_id){
                $store_id = $request->store_id;
                $request->validate([
                    'store_name' => 'required|string|max:255',
                    'description' => 'required',
                    'city' => 'required',
                    'area' => 'required',
                    'category' => 'required',
                    // 'sub_category' => 'nullable|numeric',
                    'google_map_link' => 'required|string',
                    'owner_name' => 'required|string|max:255',
                    'mobile' => 'required|unique:stores,phone,' . $store_id,
                    'email' => 'required|email',
                    // 'password' => 'required',
                    'offer_percentage' => 'required|numeric',
                    'offer_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'store_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'store_banner' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                $listing = Store::find($store_id);
                $message = 'Store updated successfully';
            }
            else{

                $request->validate([
                    'store_name' => 'required|string|max:255',
                    'description' => 'required',
                    'city' => 'required',
                    'area' => 'required',
                    'category' => 'required',
                    // 'sub_category' => 'nullable|numeric',
                    'google_map_link' => 'required|string',
                    'owner_name' => 'required|string|max:255',
                    'mobile' => 'required|unique:stores,phone',
                    'email' => 'required|email',
                    // 'password' => 'required',
                    'offer_percentage' => 'required|numeric',
                    'offer_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'store_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'store_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                $listing = new Store;
                $message = 'Store Added successfully';
            }
            $listing->name = $request->store_name;
            $listing->phone  = $request->mobile;
            $listing->email = $request->email;
            if ($request->hasFile('offer_image')) {
                $filePath = public_path('images/business-images/'.$listing->offer_image) ;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $imageName = time().'.offer_image-'.$request->offer_image->extension();
                $request->offer_image->move(public_path('images/business-images'), $imageName);
                $listing->offer_image = $imageName;
            }
            if ($request->hasFile('store_logo')) {
                $filePath = public_path('images/business-images/'.$listing->logo) ;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $imageName = time().'.store_logo-'.$request->store_logo->extension();
                $request->store_logo->move(public_path('images/business-images'), $imageName);
                $listing->logo = $imageName;
            }
            if ($request->hasFile('store_banner')) {
                $filePath = public_path('images/business-images/'.$listing->cover_photo) ;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $imageName = time().'.store_banner-'.$request->store_banner->extension();
                $request->store_banner->move(public_path('images/business-images'), $imageName);
                $listing->cover_photo = $imageName;
            }
            $listing->vendor_id = auth()->user()->id ?? 1;
            $listing->meta_description = $request->description;
            $listing->city_id = $request->city;
            $listing->area_id = $request->area;
            $listing->store_category = $request->category;
            $listing->owner_name = $request->owner_name;
            $listing->offer_percentage = $request->offer_percentage;
            // $listing->password = $request->password;
            $listing->map_location_link = $request->google_map_link;
            $listing->latitude = '12.918804202266855';
            $listing->longitude = '77.65186298277348';
            $listing->module_id = 2;
            $listing->zone_id = 2;
            $listing->active = 1;
            $listing->save();
            return back()->with('success',$message);
        } catch (ValidationException $e) {
            return redirect()->back()->with(['errors' => $e->errors()]);
        }
    }

    public function businessList(){
        $businessList = Store::paginate(50);
        return view('admin-views.customer.business.business-list',get_defined_vars());
    }

    public function editBusiness($store_id){
        $cities = cities::where('status',1)->get();
        $areas = areas::where('status',1)->get();
        $categories = Category::where('parent_id',0)->where('status',1)->get();
        $store = Store::find($store_id);
        return view('admin-views.customer.business.edit-business',get_defined_vars());
    }


    // Api functions for posts
    public function apiindex(Request $request){
        $posts = Post::where('user_id', 2)->get();
        return response()->json($posts, 200);
    }

    public function apisavePost(Request $request){
        try {
            if($request->post_id){
                $post_id = $request->post_id;
                $validator = Validator::make($request->all(), [
                    'title' => 'required|string|max:255',
                    'address' => 'required|string|max:255',
                    'rent_per_month' => 'required|numeric|min:0',
                    'deposit' => 'required|numeric|min:0',
                    'bedrooms' => 'required|integer|min:0',
                    'bathrooms' => 'required|integer|min:0',
                    'floors' => 'required|integer|min:0',
                    'description' => 'required|string',
                    'possession_date' => 'required|date', // Ensure that possession_date is a valid date
                    'image1' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validating image1 as an example, you can apply similar rules to other images
                    'image2' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image fields
                    'image3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image4' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    // 'amenities' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => Helpers::error_processor($validator)], 403);
                }
                $listing = Post::find($post_id);
                $message = 'Post updated successfully';
            }
            else{
                $validator = Validator::make($request->all(), [
                    'title' => 'required|string|max:255',
                    'address' => 'required|string|max:255',
                    'rent_per_month' => 'required|numeric|min:0',
                    'deposit' => 'required|numeric|min:0',
                    'bedrooms' => 'required|integer|min:0',
                    'bathrooms' => 'required|integer|min:0',
                    'floors' => 'required|integer|min:0',
                    'description' => 'required|string',
                    'possession_date' => 'required|date',
                    'image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image4' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    // 'amenities' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => Helpers::error_processor($validator)], 403);
                }
                $listing = new Post();
                $message = 'Post Added successfully';
            }
            // $listing->user_id = auth()->user()->id ?? 0;
            $listing->user_id = 2;
            $listing->title = $request->title;
            $listing->address = $request->address;
            $listing->rent_per_month = $request->rent_per_month;
            $listing->deposit = $request->deposit;
            $listing->bedrooms = $request->bedrooms;
            $listing->bathrooms = $request->bathrooms;
            $listing->floors = $request->floors;
            $listing->description = $request->description;
            $listing->possession_date = $request->possession_date;

            // Handle image uploads
            if ($request->hasFile('image1')) {
                $imageName = time().'.img1-'.$request->image1->extension();
                $request->image1->move(public_path('images/post-images'), $imageName);
                $listing->image1 = $imageName;
            }
            if ($request->hasFile('image2')) {
                $imageName = time().'.img2-'.$request->image2->extension();
                $request->image2->move(public_path('images/post-images'), $imageName);
                $listing->image2 = $imageName;
            }
            if ($request->hasFile('image3')) {
                $imageName = time().'.img3-'.$request->image3->extension();
                $request->image3->move(public_path('images/post-images'), $imageName);
                $listing->image3 = $imageName;
            }
            if ($request->hasFile('image4')) {
                $imageName = time().'.img4-'.$request->image4->extension();
                $request->image4->move(public_path('images/post-images'), $imageName);
                $listing->image4 = $imageName;
            }
            $listing->amenities = json_encode($request->amenities);
            $listing->post_type = 1;
            $listing->save();
            return response()->json(['status' => 'success', 'message' => $message], 200);
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to save/store business'], 500);
        }
    }


    public function apieditPost($post_id){

        try {
            $post = Post::select('*')->where('id',$post_id)->first();
            if (!$post) {
                return response()->json(['status' => 'error','message' => 'Post not found'], 404);
            }
            return response()->json(['status' => 'success', 'data' => $post], 200);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ], 500);
        }

    }

}
