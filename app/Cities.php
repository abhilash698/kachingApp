<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
	protected $table = 'cities';
    protected $fillable = ['title'];
    public $timestamps = false;

    public function Areas(){
    	return $this->hasMany('App\Areas','city_id');
    }
}
