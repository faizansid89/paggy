<?php

namespace App\Models;

use App\Http\Controllers\LiveStreamController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Livestream;

class Payment extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function livestream(){
        return $this->hasOne(Livestream::class,'id','stream_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function role(){
        return $this->hasOne(Role::class,'id','user_type');
    }
    public function webinar(){
        return $this->hasOne(Webinar::class,'id','webinar_id');
    }

}
