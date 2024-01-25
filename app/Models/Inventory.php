<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = "inventory";

    public $guarded = [];

//    protected $appends = ['remaining_qty'];

    public function branch(){
        return $this->hasMany(Branch::class,'id','branch_id');
    }

    public function product(){
        return $this->hasOne(Products::class,'id','product_id')->with('brands','productUnitState');
    }

    public function category(){
        return $this->hasOne(Categories::class,'id','category_id');
    }

    public function productUnitStatus()
    {
        return $this->hasMany(ProductUnitStatus::class,'product_id','product_id');
    }

//    public function getRemainingQtyAttribute()
//    {
//        if ($this->productUnitStatus->isNotEmpty()) {
//            $productUnitStatus = $this->productUnitStatus->first(); // Assuming you're only using the first related status
//            return floor($this->quantity / $productUnitStatus->quantity); // Round to the nearest integer
//        }
//
//        return null; // Handle this case as needed
//    }

}
