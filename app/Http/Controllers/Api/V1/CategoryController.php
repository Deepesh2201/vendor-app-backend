<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\CategoryLogic;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function get_categories(Request $request,$search=null)
    {
        try {
            $key = explode(' ', $search);
            $featured = $request->query('featured');
            $categories = Category::withCount(['products','childes'])->with(['childes' => function($query)  {
                $query->withCount(['products','childes']);
            }])
            ->where(['position'=>0,'status'=>1])
            ->when(config('module.current_module_data'), function($query){
                $query->module(config('module.current_module_data')['id']);
            })
            ->when($featured, function($query){
                $query->featured();
            })
            ->when($search, function($query)use($key){
                $query->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%". $value."%");
                    }
                });
            })
            ->orderBy('priority','desc')->get();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }

    public function get_childes($id)
    {
        
        try {
            $categories = Category::with('parent')->where(['parent_id' => $id,'status'=>1])->orderBy('priority','desc')->get();
            // $categories = Category::select('*')->where(['parent_id' => $id,'status'=>1])->orderBy('priority','desc')->get();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }

    public function main_categories(){
        try {
            $categories = Module::where(['status'=>1])->get();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
           

    }

    public function get_products($id, Request $request)
    {
        if (!$request->hasHeader('zoneId')) {
            $errors = [];
            array_push($errors, ['code' => 'zoneId', 'message' => translate('messages.zone_id_required')]);
            return response()->json([
                'errors' => $errors
            ], 403);
        }
        $validator = Validator::make($request->all(), [
            'limit' => 'required',
            'offset' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $zone_id= $request->header('zoneId');

        $type = $request->query('type', 'all');

        $data = CategoryLogic::products($id, $zone_id, $request['limit'], $request['offset'], $type);
        $data['products'] = Helpers::product_data_formatting($data['products'] , true, false, app()->getLocale());
        return response()->json($data, 200);
    }


    public function get_stores($id, Request $request)
    {
        if (!$request->hasHeader('zoneId')) {
            $errors = [];
            array_push($errors, ['code' => 'zoneId', 'message' => translate('messages.zone_id_required')]);
            return response()->json([
                'errors' => $errors
            ], 403);
        }
        $validator = Validator::make($request->all(), [
            'limit' => 'required',
            'offset' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $zone_id= $request->header('zoneId');
        $longitude= $request->header('longitude');
        $latitude= $request->header('latitude');  
        $type = $request->query('type', 'all');

        $data = CategoryLogic::stores($id, $zone_id, $request['limit'], $request['offset'], $type,$longitude,$latitude);
        $data['stores'] = Helpers::store_data_formatting($data['stores'] , true);
        return response()->json($data, 200);
    }

// public function get_stores($id, Request $request)
// {
//     if (!$request->hasHeader('zoneId')) {
//         $errors = [];
//         array_push($errors, ['code' => 'zoneId', 'message' => translate('messages.zone_id_required')]);
//         return response()->json([
//             'errors' => $errors
//         ], 403);
//     }
    
//     $validator = Validator::make($request->all(), [
//         'limit' => 'required',
//         'offset' => 'required',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => Helpers::error_processor($validator)], 403);
//     }

//     $zone_id = $request->header('zoneId');
//     $type = $request->query('type', 'all');

//     $data = CategoryLogic::stores($id, $zone_id, $request['limit'], $request['offset'], $type);
//     $data['stores'] = Helpers::store_data_formatting($data['stores'], true);
//     return response()->json($data, 200);
// }


    public function get_all_products($id,Request $request)
    {
        if (!$request->hasHeader('zoneId')) {
            $errors = [];
            array_push($errors, ['code' => 'zoneId', 'message' => translate('messages.zone_id_required')]);
            return response()->json([
                'errors' => $errors
            ], 403);
        }
        $zone_id= $request->header('zoneId');

        try {
            return response()->json(Helpers::product_data_formatting(CategoryLogic::all_products($id, $zone_id), true, false, app()->getLocale()), 200);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }

    public function get_sub_categories($id){
      
        if($id == 0){
            $id = -1;
        }
        try {
            $categories = Category::with('parent')->where(['parent_id' => $id,'status'=>1])->orderBy('priority','desc')->get();
            // $categories = Category::select('*')->where(['parent_id' => $id,'status'=>1])->orderBy('priority','desc')->get();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }
}
