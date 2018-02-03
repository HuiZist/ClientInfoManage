<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreContactBTypeRequest;
use Illuminate\Support\Facades\Auth;
use App\ContactBType;
use App\ContactSType;

class ContactBTypeController extends Controller
{
    public function show(){
    	$this->authorize('isAdmin');

    	$btypes = ContactBType::with('stype')->get();
    	return view('manage.contactType',compact('btypes'));
    }

    public function add(StoreContactBTypeRequest $request){
    	$this->authorize('isAdmin');

    	$data=[
    		'name'=>$request->get('btype'),
    		'create_id'=>Auth::id(),
            'detail'=>$request->get('detail'),
            'ord'=>$request->get('ord'),
    	];

    	ContactBType::create($data);
    	return redirect()->route('contactType.show');
    }

    public function delete($btypeId){
    	$this->authorize('isAdmin');
    	//先将该大类下小类删除
    	ContactBType::find($btypeId)->stype()->delete();
    	ContactBType::find($btypeId)->delete();
    	return redirect()->route('contactType.show');
    }

    public function editor($btypeId){
        $this->authorize('isAdmin');

        $conBType = ContactBType::find($btypeId);
        return view('manage.conBType',compact('conBType'));
    }

    public function update(StoreContactBTypeRequest $request){
        $this->authorize('isAdmin');

        $data = [
            'name'=>$request->get('btype'),
            'detail'=>$request->get('detail'),
            'ord'=>$request->get('ord'),
        ];
        ContactBType::find($request->get('b_id'))->update($data);
        return redirect()->route('contactType.show');
    }
}
