<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\ClientTitle;

class UserController extends Controller
{
    //
    public function passwordReset(Request $request){
    	$user = User::where('account',$request->get('account'))->select('account','question')->first();
        return view('user.passwordReset',compact('user'));
    }

    public function passwordResetting(Request $request){
    	$user = User::where('account',$request->get('account'))->first();
    	if($request->get('password')!==$request->get('password_confirmation')){
    		return view('user.passwordReset',compact('user'));
    	}
    	if(password_verify($request->get('answer'),$user->answer)){
    		User::where('account',$request->get('account'))->update(['password'=>bcrypt($request->get('password'))]);
    		return view('auth.login');
    	}
    	return view('user.passwordReset',compact('user'));
    }

    public function memberShow(){
        $this->authorize('isSupAdmin');

        $users = User::all();
        return view('manage.memberShow',compact('users'));
    }

    public function adminSet($userId){
        $this->authorize('isSupAdmin');

        User::find($userId)->update(['is_admin'=>66]);
        return redirect()->route('manage.memberShow');
    }

    public function memberSet($userId){
        $this->authorize('isSupAdmin');

        User::find($userId)->update(['is_admin'=>0]);
        return redirect()->route('manage.memberShow');
    }

    public function memberDelete($userId){
        $this->authorize('isSupAdmin');

        User::find($userId)->delete();
        return redirect()->route('manage.memberShow');
    }

    public function title(){
        $this->authorize('isAdmin');

        $clients = ClientTitle::find(1)->toArray();
        $contacts = ClientTitle::find(2)->toArray();
        return view('manage.title',compact('clients','contacts'));
    }

    public function cliUpdate(Request $request){
        $this->authorize('isAdmin');

        $data = $request->toArray();
        ClientTitle::find(1)->update($data);
        return redirect()->route('title.show');
    }

    public function conUpdate(Request $request){
        $this->authorize('isAdmin');

        $data = $request->toArray();
        ClientTitle::find(2)->update($data);
        return redirect()->route('title.show');
    }
}
