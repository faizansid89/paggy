<?php

namespace App\Models;

use Carbon\Traits\Units;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;

    public $guarded = [];

    public function purchase()
    {
        return $this->belongsTo( Purchases::class, 'purchase_id');
    }

    public function product()
    {
        return $this->hasOne( Products::class, 'id', 'product_id');
    }
    public function supplier()
    {
        return $this->belongsTo( Supplier::class, 'purchase_id', 'id');
    }

    public function units()
    {
        return $this->hasMany( ProductUnitStatus::class, 'product_id', 'product_id');
    }

    public function receiveItem()
    {
        return $this->belongsTo( ReceiveItem::class, 'id', 'purchase_detail_id');
    }
}
