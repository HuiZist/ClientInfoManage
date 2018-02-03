<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Procedure;

class Supple extends Model
{
    //
    protected $fillable = [
    	'content','pro_id','post_name','post_account',
    ];

    public function procedure(){
    	return $this->belongsTo('App\Procedure','id','pro_id');
    }
}
