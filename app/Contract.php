<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //
    protected $fillable = [
    	'operator_account','operator_name','A','B','C','D',
    	'E','F','G','H',
    ];

    public function client(){
    	return $this->belongsTo('App\Client','D','B');
    }

}
