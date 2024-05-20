<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Inventory;
use App\Models\Products;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function priceRange(Request $request){
        $start=$request->start;
        $end=$request->end;
        $branch_id=$request->branch_id;


        $product=Inventory::with(['product' => function($q) use($start,$end) {
                        // Query the name field in status table
                        $q->where('sale_price', '>', $start)->where('sale_price','<',$end);// '=' is optional
                    }])
                        ->where('branch_id', $branch_id)
                        ->get();
            return $product->toArray();

    }


    public function categoryBrand(Request $request){

        $option['cate'] = Products::whereIn('category_id',$request->cat)->get();
        $option['bran'] = Products::whereIn('brand_id',$request->bran)->get();
        return $option;

    }


    public function search($search){

        $data = Products::where('name', 'like', '%'.$search.'%')
            ->get();

        $html='<ul>';
        foreach ($data as $ser){
            $html.="<li><a href='/wecareWebsite/product_detail/".$ser->id ."'> ".$ser->name."</a>";
            $html.="<img src='".$ser->images."'></li>";
        }
        $html.='</ul>';
        return $html;
    }

    public function product_search($search){

        $data = Products::with('inventery','productUnitState1')->where('name', 'like', '%'.$search.'%')->orwhere('sku', 'like', '%'.$search.'%')
            ->get();

        return $data;
    }


    public function update_product_inventory(Request $request){
        $inventory = Inventory::where('sku', $request->sku)->where('branch_id', $request->branch_id)->first();
        if($inventory != null){
            $inventory->branch_quantity_time = $inventory->quantity;
            $inventory->branch_quantity = $request->branch_quantity;
            $inventory->save();
            return 'Inventory Updated';
        }
        else {
            return 'Product Not Found';
        }
    }
}