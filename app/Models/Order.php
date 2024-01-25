<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function user()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
    public function order_detail()
    {
        return $this->hasMany(Orderitem::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
