<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapyForm extends Model
{
    use HasFactory;

    protected $table = "therapy_form";
    protected $guarded=[];
}
