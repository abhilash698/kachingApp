<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordOtpReset extends Model
{
	protected $table = 'password_otp_resets';
    protected $fillable = ['user_id','token','code'];
}
