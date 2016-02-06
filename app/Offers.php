<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Offers extends Model
{
    use SoftDeletes;
    
    protected $table = 'offers';
    protected $fillable = ['store_id','title','fineprint','startDate','endDate','status'];
    protected $dates = ['deleted_at'];

    public function Store()
    {
        return $this->belongsTo('App\MerchantStore','store_id','id');
    }

    public function Favourites(){
    	return $this->belongsToMany('App\User','offer_favourite','offer_id','user_id');
    }

    public function Votes(){
    	return $this->belongsToMany('App\User','offer_vote','offer_id','user_id')->withPivot('status');
    }

    public function favouriteCount(){
        return $this->Favourites()->selectRaw('count("offer_favourite.offer_id") as aggregate')->groupBy('offer_favourite.offer_id');
    }

    public function votesCount(){
        return $this->Votes()->where('offer_vote.status',true)->selectRaw('count("offer_vote.offer_id") as aggregate')->groupBy('offer_vote.offer_id');
    }


}
