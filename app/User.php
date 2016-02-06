<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, EntrustUserTrait{
        EntrustUserTrait::can as may;
        Authorizable::can insteadof EntrustUserTrait;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mobile','name', 'email', 'password','profileImg'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token' ,'status'];

    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.mobile' => 10,
            'users.email' => 5,
        ],
    ];


    public function Favourites(){
        return $this->belongsToMany('App\Offers','offer_favourite','user_id','offer_id');
    }

    public function Votes(){
        return $this->belongsToMany('App\Offers','offer_vote','user_id','offer_id');
    }

    public function Stores(){
        return $this->hasMany('App\MerchantStore','user_id');
    }
    
}
