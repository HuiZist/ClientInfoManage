<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statdef extends Model
{
    protected $fillable = [
    	'btime','etime','scount','stcount','acount','atcount','bcount','btcount','ccount','ctcount',
    ];
}
