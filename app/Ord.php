<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ord extends Model
{
    protected $fillable = [
    	'conStr','conOrd','cliStr','cliOrd','user_id',
    ];

    public function user(){
    	return $this->belongsTo('App\User','id','user_id');
    }
}
