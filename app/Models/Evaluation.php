<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    public $guarded=[];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function webinar(){
        return $this->hasone(Webinar::class,'id','webinar_id');
    }

    public function liststream(){
        return $this->hasone(Livestream::class,'id','webinar_id');
    }

}
