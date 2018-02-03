<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'account', 'password','question','answer','is_admin','active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','answer', 'remember_token',
    ];

    public function clients(){
        return $this->hasMany('App\Client','A','account');
    }

    public function contracts(){
        return $this->hasMany('App\Contract','operator_account','account');
    }

    public function remind(){
        return $this->hasMany('App\Remind','user_id','id');
    }

    public function ord(){
        return $this->hasOne('App\Ord','user_id','id');
    }
}
