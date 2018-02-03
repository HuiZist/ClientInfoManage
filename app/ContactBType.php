<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContactSType;

class ContactBType extends Model
{
    protected $fillable = [
    	'name','create_id','detail','ord',
    ];

    public function stype(){
    	return $this->hasMany('App\ContactSType','b_id','id');
    }

    
}
