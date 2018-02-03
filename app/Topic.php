<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    protected $fillable = [
    	'post_account','post_name','product_type','topic_type','source','content',
    ];
}
