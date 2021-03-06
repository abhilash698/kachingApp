<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantStore extends Model
{

    protected $tags;
    

    protected $table = 'merchant_store';
    protected $fillable = ['user_id','store_name','logoUrl','description','cost_two','latitude','longitude','landline','veg','is_parent','is_child','parent_id'];

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

    public function OffersCount()
    {
        return $this->Offers()->selectRaw('store_id, count(*) as count')->groupBy('store_id');
    }

    public function scopeParents($query)
    {
        return $query->where('status',true)->where('is_parent', true)->where('is_child',false)->select('store_name','id','is_parent','is_child');
    }

    public function scopeChilds($query,$parent_id){
        return $query->where('status',true)->where('is_parent', false)->where('is_child',true)->where('parent_id',$parent_id)->select('store_name','id','is_parent','is_child');
    }
}
