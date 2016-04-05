<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
	protected $table = 'areas';
    protected $fillable = ['title','city_id'];
    public $timestamps = false;

    public function City(){
    	return $this->belongsTo('App\Cities','city_id','id');
    }
}
