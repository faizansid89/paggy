<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Appoinment extends Authenticatable
{
   protected $table = "appoinments";
   public $guarded = [];

   public function service()
   {
      return $this->belongsTo(Services::class, 'service_id', 'id');
   }

   public function user()
   {
      return $this->belongsTo(User::class, 'user_id', 'id');
   }
}
