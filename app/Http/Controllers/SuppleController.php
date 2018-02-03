<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Procedure;
use App\User;
use App\Supple;

class SuppleController extends Controller
{
    //
    public function createView($proceId){
    	$procedure = Procedure::find($proceId);
    	return view('supple.create',compact('proceId','procedure'));
    }

    public function create(Request $request){
    	$user = User::where('id',Auth::id())->select('name','account')->first();
    	$data = [
    		'content'=>$request->get('content'),
    		'pro_id'=>$request->get('proceId'),
    		'post_name'=>$user->name,
    		'post_account'=>$user->account,
    	];
    	Supple::create($data);
    	return redirect()->route('procedure.show');
    }

    public function destroy($supId){
    	Supple::destroy($supId);
    	return redirect()->route('procedure.show');
    }
}
