<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppElement extends Model
{
	protected $table = 'app_elements';
    protected $fillable = ['mabout','msupport'];
}
