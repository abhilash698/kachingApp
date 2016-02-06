<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantStore extends Model
{

    protected $tags;
    

    protected $table = 'merchant_store';
    protected $fillable = ['user_id','store_name','logoUrl','description','cost_two','latitude','longitude'];

    public function Merchant()
    {
        return $this->belongsTo('App\User','user_id','id')->select(array('id', 'mobile' ,'name', 'profileImg','email'));
    }

    public function Address(){
    	return $this->hasOne('App\MerchantStoreAddress','store_id');
    }

    public function Offers(){
    	return $this->hasMany('App\Offers','store_id');
    }

    public function Tags(){
        return $this->belongsToMany('App\Tag', 'tag_store', 'store_id', 'tag_id');
    }

}
