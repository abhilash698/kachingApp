<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantStoreAddress extends Model
{
    protected $table = 'merchant_store_address';
    protected $fillable = ['store_id','street','city_id','state_id','country_id','pincode','latitude','longitude'];

    public function Store()
    {
        return $this->belongsTo('App\MerchantStore','store_id','id');
    }

    public function Country()
    {
        return $this->belongsTo('App\Countries','country_id','id');
    }

    public function State()
    {
        return $this->belongsTo('App\States','state_id','id');
    }

    public function City()
    {
        return $this->belongsTo('App\Cities','city_id','id');
    }

    
}
