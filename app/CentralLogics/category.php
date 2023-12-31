<?php

namespace App\CentralLogics;

use App\Models\Item;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryLogic
{
    public static function parents()
    {
        return Category::where('position', 0)->get();
    }

    public static function child($parent_id)
    {
        return Category::where(['parent_id' => $parent_id])->get();
    }

    public static function products($category_id, $zone_id, int $limit,int $offset, $type)
    {
        $paginator = Item::
        whereHas('module.zones', function($query)use($zone_id){
            $query->whereIn('zones.id', json_decode($zone_id, true));
        })
        ->whereHas('store', function($query)use($zone_id){
            $query->whereIn('zone_id', json_decode($zone_id, true))->whereHas('zone.modules',function($query){
                $query->when(config('module.current_module_data'), function($query){
                    $query->where('modules.id', config('module.current_module_data')['id']);
                });
            });
        })
        ->whereHas('category',function($q)use($category_id){
            return $q->when(is_numeric($category_id),function ($qurey) use($category_id){
                return $qurey->whereId($category_id)->orWhere('parent_id', $category_id);
            })
            ->when(!is_numeric($category_id),function ($qurey) use($category_id){
                $qurey->where('slug', $category_id);
            });
        })
        ->active()->type($type)->latest()->paginate($limit, ['*'], 'page', $offset);

        return [
            'total_size' => $paginator->total(),
            'limit' => $limit,
            'offset' => $offset,
            'products' => $paginator->items()
        ];
    }


    public static function stores($category_id, $zone_id, int $limit,int $offset, $type,$longitude=0,$latitude=0)
    {
        $paginator = Store::
        withOpen($longitude??0,$latitude??0)
        // ->whereHas('items.category', function($query)use($category_id){
        //     return $query->whereId($category_id)->orWhere('parent_id', $category_id);
        // })
        ->whereHas('items.category',function($q)use($category_id){
            return $q->when(is_numeric($category_id),function ($qurey) use($category_id){
                return $qurey->whereId($category_id)->orWhere('parent_id', $category_id);
            })
            ->when(!is_numeric($category_id),function ($qurey) use($category_id){
                $qurey->where('slug', $category_id);
            });
        })
        ->when(config('module.current_module_data'), function($query)use($zone_id){
            $query->whereHas('zone.modules', function($query){
                $query->where('modules.id', config('module.current_module_data')['id']);
            })->module(config('module.current_module_data')['id']);
            if(!config('module.current_module_data')['all_zone_service']) {
                $query->whereIn('zone_id', json_decode($zone_id, true));
            }
        })
        ->active()->type($type)->latest()->paginate($limit, ['*'], 'page', $offset);

                
        $paginator->each(function ($store) {
            $category_ids = DB::table('items')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->selectRaw('
                CAST(categories.id AS UNSIGNED) as id,
                categories.parent_id
            ')
            ->where('items.store_id', $store->id)
            ->where('categories.status', 1)
            ->groupBy('id', 'categories.parent_id')
            ->get();

            $data = json_decode($category_ids, true);

            $mergedIds = [];

            foreach ($data as $item) {
                if ($item['id'] != 0) {
                    $mergedIds[] = $item['id'];
                }
                if ($item['parent_id'] != 0) {
                    $mergedIds[] = $item['parent_id'];
                }
            }

            $category_ids = array_values(array_unique($mergedIds));
            
            $store->category_ids = $category_ids;
            $store->discount_status = !empty($store->items->where('discount', '>', 0));
        });

        return [
            'total_size' => $paginator->total(),
            'limit' => $limit,
            'offset' => $offset,
            'stores' => $paginator->items()
        ];
    }

//     public static function stores($category_id, $zone_id, int $limit, int $offset, $type)
// {
//     $paginator = Store::
//         withOpen()
//         ->whereHas('items.category', function ($q) use ($category_id) {
//             return $q->when(is_numeric($category_id), function ($query) use ($category_id) {
//                 return $query->whereId($category_id)->orWhere('parent_id', $category_id);
//             })->when(!is_numeric($category_id), function ($query) use ($category_id) {
//                 $query->where('slug', $category_id);
//             });
//         })
//         ->when(config('module.current_module_data'), function ($query) use ($zone_id) {
//             $query->whereHas('zone.modules', function ($query) {
//                 $query->where('modules.id', config('module.current_module_data')['id']);
//             })->module(config('module.current_module_data')['id']);
//             if (!config('module.current_module_data')['all_zone_service']) {
//                 $query->whereIn('zone_id', json_decode($zone_id, true));
//             }
//         })
//         ->active()->type($type)->latest()->paginate($limit, ['*'], 'page', $offset);

//     $paginator->each(function ($store) {
//         $category_ids = DB::table('items')
//             ->join('categories', 'items.category_id', '=', 'categories.id')
//             ->selectRaw('
//                 CAST(categories.id AS UNSIGNED) as id,
//                 categories.parent_id
//             ')
//             ->where('items.store_id', $store->id)
//             ->where('categories.status', 1)
//             ->groupBy('id', 'categories.parent_id')
//             ->get();

//         $data = json_decode($category_ids, true);

//         $mergedIds = [];

//         foreach ($data as $item) {
//             if ($item['id'] != 0) {
//                 $mergedIds[] = $item['id'];
//             }
//             if ($item['parent_id'] != 0) {
//                 $mergedIds[] = $item['parent_id'];
//             }
//         }

//         $category_ids = array_values(array_unique($mergedIds));

//         $store->category_ids = $category_ids;
//         $store->discount_status = !empty($store->items->where('discount', '>', 0));
//     });

//     return [
//         'total_size' => $paginator->total(),
//         'limit' => $limit,
//         'offset' => $offset,
//         'stores' => $paginator->items()
//     ];
// }


    public static function all_products($id, $zone_id)
    {
        $cate_ids=[];
        array_push($cate_ids,(int)$id);
        foreach (CategoryLogic::child($id) as $ch1){
            array_push($cate_ids,$ch1['id']);
            foreach (CategoryLogic::child($ch1['id']) as $ch2){
                array_push($cate_ids,$ch2['id']);
            }
        }

        return Item::whereIn('category_id', $cate_ids)
        ->whereHas('module.zones', function($query)use($zone_id){
            $query->whereIn('zones.id', json_decode($zone_id, true));
        })
        ->whereHas('store', function($query)use($zone_id){
            $query->whereIn('zone_id', json_decode($zone_id, true))->whereHas('zone.modules',function($query){
                $query->when(config('module.current_module_data'), function($query){
                    $query->where('modules.id', config('module.current_module_data')['id']);
                });
            });
        })
        ->get();
    }
}
