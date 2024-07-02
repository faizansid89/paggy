<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Appoinment extends Authenticatable
{
   protected $table = "appoinments";
   public $guarded = [];

   public function service()
   {
      return $this->belongsTo(Services::class, 'id', 'service_id');
   }
}
