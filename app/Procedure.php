<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    //
    protected $fillable = [
    	'post_time','post_name','post_account','btype','stype','content',
    ];

    public function supples(){
    	return $this->hasMany('App\Supple','pro_id','id');
    }
}
