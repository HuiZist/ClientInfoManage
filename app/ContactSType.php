<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContactBType;

class ContactSType extends Model
{
    protected $fillable = [
    	'name','b_id','create_id','detail','ord',
    ];

    public function btype(){
        return $this->belongsTo('App\ContactBType','id','b_id');
    }
}
