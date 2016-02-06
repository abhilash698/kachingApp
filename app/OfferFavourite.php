<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferFavourite extends Model
{
    protected $table = 'offer_favourite';
    protected $fillable = ['user_id','offer_id'];
}
