<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSmsCode extends Model
{
	use SoftDeletes;

    protected $table = 'user_sms_code';
    protected $fillable = ['mobile_id','code','reference_id'];
    protected $dates = ['deleted_at'];
}
