<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($sale) {
//            $branch = getBranch();
//            $branch_shortcode = $branch->short_code;

            $branch = 2;
            $branch_shortcode = "web";

            $sale->invoice_number = $branch_shortcode. '-' . str_pad(DB::table('sales')->max('id') + 1, 9, '0', STR_PAD_LEFT);
        });
    }


//    protected static function boot()
//    {
//        parent::boot();
//        static::creating(function ($sale) {
//            $sale->invoice_number = 'INV-' . str_pad(DB::table('sales')->max('id') + 1, 9, '0', STR_PAD_LEFT);
//        });
//    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function sales_items()
    {
        return $this->hasMany(SaleItem::class,'sales_id', 'sale_auto_id');
    }


    public function salesItems()
    {
        return $this->belongsTo(SaleItem::class);
    }

    public function branch()
    {
        return $this->hasOne(Branches::class,'id', 'branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

}
