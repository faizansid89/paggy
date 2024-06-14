<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalSupervisionForm extends Model
{
    use HasFactory;

    protected $table = "clinical_supervision_form";
    protected $guarded=[];
}
