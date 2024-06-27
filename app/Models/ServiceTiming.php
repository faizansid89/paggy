<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ServiceTiming extends Authenticatable
{
   protected $table = "service_timing";
   public $guarded = [];

   public function service()
   {
      return $this->belongsTo(Services::class, 'id', 'service_id');
   }
}
