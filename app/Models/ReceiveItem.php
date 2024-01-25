<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveItem extends Model
{
    use HasFactory;

    public $guarded = [];

    public function purchaseDetail()
    {
        return $this->belongsTo( PurchaseDetails::class, 'purchase_detail_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo( Products::class, 'product_id');
    }

    public function productUnitState()
    {
        return $this->hasMany(ProductUnitStatus::class, 'product_id', 'product_id');
    }

    public function purchaseDetailData()
    {
        //return $this->hasOne( PurchaseDetails::class, 'id', 'purchase_detail_id')->latest('id');
        return $this->hasOne( PurchaseDetails::class, 'product_id', 'product_id')->latest('id');
    }

}
