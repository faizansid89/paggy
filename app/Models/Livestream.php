<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livestream extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function evaluation(){
        return $this->belongsTo(Evaluation::class);
    }

}
