<?php

namespace App\Models;

use App\Http\Controllers\ProductsController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;


class ServicesDownloadFile extends Authenticatable
{
   use HasFactory;

   protected $table = "services_download_file";
   public $guarded = [];
}
