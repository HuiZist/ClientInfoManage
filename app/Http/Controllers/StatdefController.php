<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statdef;
use App\StatTitle;

class StatdefController extends Controller
{
    public function show(){
    	$this->authorize('isAdmin');

        $statTitle = StatTitle::find(1);

    	$statdef = Statdef::find(1);
    	return view('manage.statdef',compact('statdef','statTitle'));
    }

    public function create(Request $request){
    	$this->authorize('isAdmin');
    	
    	$data = [
    		'btime'=>$request->get('btime'),
    		'etime'=>$request->get('etime'),
    		'scount'=>$request->get('scount'),
    		'stcount'=>$request->get('stcount'),
    		'acount'=>$request->get('acount'),
    		'atcount'=>$request->get('atcount'),
    		'bcount'=>$request->get('bcount'),
    		'btcount'=>$request->get('btcount'),
    		'ccount'=>$request->get('ccount'),
    		'ctcount'=>$request->get('ctcount'),
    	];

    	Statdef::find(1)->update($data);
    	return redirect()->route('statdef.show');
    }

    public function titleUpdate(Request $request){
        $data = [
            's'=>$request->get('S'),
            'a'=>$request->get('A'),
            'b'=>$request->get('B'),
            'c'=>$request->get('C'),
        ];
        StatTitle::find(1)->update($data);
        return redirect()->route('statdef.show');
    }
}
