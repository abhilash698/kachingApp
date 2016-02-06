<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['title'];
    public $timestamps = false;

    public function stores(){
    	return $this->belongsToMany('App\MerchantStore', 'tag_store', 'tag_id', 'store_id');
    }
}
