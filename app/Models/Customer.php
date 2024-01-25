<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class Customer extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $guarded = [];

    public function generateApiToken()
    {
        $randomString = Str::random(20);
        $apiToken = $this->id . '-' . $randomString;
        //$expiresAt = Carbon::now()->addMinutes(60); // Token expires after 30 minutes

        $this->api_token = $apiToken;
        //$this->token_expires_at = $expiresAt;
        $this->save();

        return $apiToken;
    }


}
