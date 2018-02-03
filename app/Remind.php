<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remind extends Model
{
    protected $fillable = [
    	'user_id','contact_id','reTime',
    ];

    public function user(){
    	return $this->belongsTo('App\User','id','user_id');
    }
}
