<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferVote extends Model
{
    protected $table = 'offer_vote';
    protected $fillable = ['user_id','offer_id','status'];

}
