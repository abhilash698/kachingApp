<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempMobile extends Model
{
	use SoftDeletes;

    protected $table = 'temp_mobile';
    protected $fillable = ['mobile'];
    protected $dates = ['deleted_at'];
}
