<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Remind;
use Carbon\Carbon;
use App\Contract;

class RemindController extends Controller
{
    public function search(){
    	$nowDate = Carbon::now('Asia/ShangHai')->toDateString();
    	$remind = Auth::user()->remind()->where('reTime',$nowDate)->first();
    	if(!!$remind){
    		$con = Contract::find($remind->contact_id)->toArray();
    		Remind::destroy($remind->id);
    	}else{
    		$con = null;
    	}
    	return json_encode($con);
    }
}
