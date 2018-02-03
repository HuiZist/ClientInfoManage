<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
    	'A','B','C','D','E','F','G',
    	'H','I','J','K','L','M','N',
    	'O','P','Q','R','S','T',
    	'U','V','W','X','Y','Z',
    	'AA','AB','AC','AD','AE','AF','AG',
    	'AH','AI','AJ',
    ];

    public function user(){
        return $this->belongsTo('App\User','account','A');
    }

    public function contracts(){
    	return $this->hasMany('App\Contract','B','D');
    }
}
