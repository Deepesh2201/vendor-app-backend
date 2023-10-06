<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Amenity;
use App\Models\Post;

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
}
