<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_auto_id', 'sales_id');
    }

    public function sales()
    {
        return $this->hasOne(Sale::class,'id','sales_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }

    public function productUnitStatus()
    {
        return $this->hasMany(ProductUnitStatus::class, 'product_id', 'product_id');
    }

}
