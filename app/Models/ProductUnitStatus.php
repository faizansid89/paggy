<?php

namespace App\Models;

use App\Http\Controllers\ProductsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnitStatus extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $table = 'product_unit_status';

    protected $appends = ['unit_name'];

    public function units()
    {
        return $this->hasOne(ProductUnit::class, 'id', 'unit_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductsController::class);
    }

    public function receiveItems()
    {
        return $this->belongsTo(ReceiveItem::class);
    }

    public function getUnitNameAttribute()
    {
        if ($this->unit_id == 1) {
            return "Pcs";
        } elseif ($this->unit_id == 2) {
            return "Strip";
        } elseif ($this->unit_id == 3) {
            return "Box";
        } elseif ($this->unit_id == 4) {
            return "Crate";
        } elseif ($this->unit_id == 5) {
            return "BOTTLE";
        } else {
            return null;
        }
    }
}
