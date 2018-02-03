<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreContactSTypeRequest;
use Illuminate\Support\Facades\Auth;
use App\ContactBType;
use App\ContactSType;

class ContactSTypeController extends Controller
{
    public function add(StoreContactSTypeRequest $request){
    	$this->authorize('isAdmin');

    	$data=[
    		'name'=>$request->get('stype'),
    		'create_id'=>Auth::id(),
    		'b_id'=>$request->get('b_id'),
            'detail'=>$request->get('detail'),
            'ord'=>$request->get('ord'),
    	];

    	ContactSType::create($data);
    	return redirect()->route('contactType.show');
    }

    public function delete($stypeId){
    	$this->authorize('isAdmin');
    	ContactSType::find($stypeId)->delete();
    	return redirect()->route('contactType.show');
    }

    public function editor($stypeId){
        $this->authorize('isAdmin');

        $conSType = ContactSType::find($stypeId);
        return view('manage.conSType',compact('conSType'));
    }

    public function update(StoreContactSTypeRequest $request){
        $this->authorize('isAdmin');

        $data = [
            'name'=>$request->get('stype'),
            'detail'=>$request->get('detail'),
            'ord'=>$request->get('ord'),
        ];
        ContactSType::find($request->get('s_id'))->update($data);
        return redirect()->route('contactType.show');
    }
}
