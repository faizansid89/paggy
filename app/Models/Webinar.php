<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;
    public $fillable=['file','related','g_pub_price','pro_price','status'];


    public function user(){
        return $this->belongsTo(User::class)->with('role');
    }
}
