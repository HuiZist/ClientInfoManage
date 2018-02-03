<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Excel;
use App\Client;
use App\ClientTitle;
use App\User;
use App\Ord;

class ClientController extends Controller
{
    //
    protected $subStr = [
    	'A','B','C','D','E','F','G',
    	'H','I','J','K','L','M','N',
    	'O','P','Q','R','S','T',
    	'U','V','W','X','Y','Z',
    	'AA','AB','AC','AD','AE','AF','AG',
    	'AH','AI','AJ',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(Request $request){
    	if(!$request->hasFile('clientExcel')){
        	abort(500, '上传文件为空！');
	    } 
	    $file = $request->file('clientExcel');
	    //判断文件上传过程中是否出错
	    if(!$file->isValid()){
	        abort(500, '上传文件出错！');
	    }
		//获取扩展名
		$ext = $file->getClientOriginalExtension();
		if($ext!='xls' && $ext!='xlsx'){
			abort(500, '文件类型错误！');
		}
		$realPath = $file->getRealPath();
		$filename = 'client/'.date('Y-m-d').'-'.uniqid().'.'.$ext;
		Storage::disk('public')->put($filename,file_get_contents($realPath));
		$this->store($filename);
		return redirect()->route('client.client');
    }
    public function store($filename){
    	$filePath = 'storage/'.iconv('UTF-8', 'GBK', $filename);
    	//分块导入
    	Excel::filter('chunk')->load($filePath)->chunk(500, function($results)
		{
			$fst = $results->first()->toArray();
			//创建数组用于存储表头
	        $dataTitle = [];
	        $i = 0;
	        foreach($fst as $t=>$v){
	        	if(!!$t){
	        		if($i>=36){
	        			abort(500, 'Excel表头超过36列！');
	        		}
	        		$dataTitle[$this->subStr[$i]] = $t;
	        		$i++;
	        	}
	        }
	        if($dataTitle['A']!=='员工号'){
	        	abort(500, 'Excel表A列名称应为员工号！');
	        }
	        if($dataTitle['B']!=='员工'){
	        	abort(500, 'Excel表B列名称应为员工！');
	        }
	        if($dataTitle['C']!=='客户姓名'){
	        	abort(500, 'Excel表C列名称应为客户姓名！');
	        }
	        if($dataTitle['D']!=='资金账号'){
	        	abort(500, 'Excel表D列名称应为资金账号！');
	        }
	        //更新数据表
	        ClientTitle::find(1)->update($dataTitle);
	        foreach($results as $row)
	        {
	            $data = $row->toArray();
		        
		        //将数组格式化存入数据库
	        	$f = 0;
	        	$item = [];
	        	foreach ($data as $key => $val) {
	        		if(!!$key){
	        			$item[$this->subStr[$f]] = $val;
	        			$f++;
	        		}
	        	}
	        	Client::create($item);
	        }
		});
    	return;
    }

    public function truncate(){
    	Client::truncate();
    	return redirect()->route('client.client');
    }

    public function getCli(){
    	if (Auth::user()->can('isAdmin')) {
		    return new Client();
		}else{
			return Auth::user()->clients();
		}
    }

    public function order(Request $request){
        $id = Auth::user()->id;
        $data = [
            "cliStr"=>$request->get('str'),
            "cliOrd"=>$request->get('ord'),
            "user_id"=>$id,
        ];
        Auth::user()->ord()->updateOrCreate(['user_id'=>$id],$data);
        return 1;
    }

    public function client()
    {
    	$strArr = [];
    	$clientTitles = ClientTitle::find(1);
    	foreach ($this->subStr as $value) {
    		if(!!$clientTitles->$value){
    			array_push($strArr,$value);
    		}
    	}
        $clients = $this->getCli();

        $order = Auth::user()->ord()->first();
        $str = (isset($order->cliStr) && $order->cliStr)?$order->cliStr:'updated_at';
        $ord = (isset($order->cliOrd) && $order->cliOrd)?$order->cliOrd:'desc';

        if($str == 'B' || $str == 'C'){
            $clients = $clients->orderByRaw("convert($str using gbk) $ord")->paginate(40);
        }else{
            $clients = $clients->orderBy($str,$ord)->paginate(40);
        }
        $order = ['str'=>$str,'ord'=>$ord];
    	
        return view('client.client',compact('clientTitles','clients','strArr','order'));
    }

    public function search(Request $request){
    	$strArr = [];
    	$clientTitles = ClientTitle::find(1);
    	foreach ($this->subStr as $value) {
    		if(!!$clientTitles->$value){
    			array_push($strArr,$value);
    		}
    	}
    	$clients = $this->getCli();

    	$request->get('A')!==null && $clients = $clients->where('A','like','%'.$request->get('A').'%');
    	$request->get('B')!==null && $clients = $clients->where('B','like','%'.$request->get('B').'%');
    	$request->get('C')!==null && $clients = $clients->where('C','like','%'.$request->get('C').'%');
    	$request->get('D')!==null && $clients = $clients->where('D','like','%'.$request->get('D').'%');
    	$request->get('E')!==null && $clients = $clients->where('E','like','%'.$request->get('E').'%');
    	if(!!$request->get('F')){
    		if($request->get('F')==='服务'){
    			$clients = $clients->where('F','=','服务');
    		}elseif($request->get('F')==='开发'){
    			$clients = $clients->where('F','=','开发');
    		}elseif($request->get('F')==='空'){
    			$clients = $clients->whereNull('F');
    		}else{
    			$clients = $clients->whereNotNull('F');
    		}
    	}

    	$request->get('H')!==null && $clients = $clients->where('H','like','%'.$request->get('H').'%');
    	if(!!$request->get('I')){
    		if($request->get('I')==='是'){
    			$clients = $clients->where('I','=','是');
    		}else{
    			$clients = $clients->whereNull('I');
    		}
    	}
    	if(!!$request->get('J')){
    		if($request->get('J')==='是'){
    			$clients = $clients->where('J','=','是');
    		}else{
    			$clients = $clients->whereNull('J');
    		}
    	}
    	if(!!$request->get('K')){
    		if($request->get('K')==='是'){
    			$clients = $clients->where('K','=','是');
    		}else{
    			$clients = $clients->whereNull('K');
    		}
    	}
    	if(!!$request->get('L')){
    		if($request->get('L')==='是'){
    			$clients = $clients->where('L','=','是');
    		}else{
    			$clients = $clients->whereNull('L');
    		}
    	}
    	if(!!$request->get('M')){
    		if($request->get('M')==='是'){
    			$clients = $clients->where('M','=','是');
    		}else{
    			$clients = $clients->whereNull('M');
    		}
    	}
    	if(!!$request->get('N')){
    		if($request->get('N')==='是'){
    			$clients = $clients->where('N','=','是');
    		}else{
    			$clients = $clients->whereNull('N');
    		}
    	}

    	if(!!$request->get('O')){
    		if($request->get('O')==='是'){
    			$clients = $clients->where('O','=','是');
    		}else{
    			$clients = $clients->whereNull('O');
    		}
    	}
    	if(!!$request->get('P')){
    		if($request->get('P')==='是'){
    			$clients = $clients->where('P','=','是');
    		}else{
    			$clients = $clients->whereNull('P');
    		}
    	}
    	if(!!$request->get('Q')){
    		if($request->get('Q')==='是'){
    			$clients = $clients->where('Q','=','是');
    		}else{
    			$clients = $clients->whereNull('Q');
    		}
    	}
    	if(!!$request->get('R')){
    		if($request->get('R')==='是'){
    			$clients = $clients->where('R','=','是');
    		}else{
    			$clients = $clients->whereNull('R');
    		}
    	}

    	if(!!$request->get('S')){
    		if($request->get('S')==='是'){
    			$clients = $clients->where('S','=','是');
    		}else{
    			$clients = $clients->whereNull('S');
    		}
    	}
    	if(!!$request->get('T')){
    		if($request->get('T')==='是'){
    			$clients = $clients->where('T','=','是');
    		}else{
    			$clients = $clients->whereNull('T');
    		}
    	}
    	if(!!$request->get('U')){
    		if($request->get('U')==='是'){
    			$clients = $clients->where('U','=','是');
    		}else{
    			$clients = $clients->whereNull('U');
    		}
    	}
    	if(!!$request->get('V')){
    		if($request->get('V')==='是'){
    			$clients = $clients->where('V','=','是');
    		}else{
    			$clients = $clients->whereNull('V');
    		}
    	}
    	if(!!$request->get('W')){
    		if($request->get('W')==='是'){
    			$clients = $clients->where('W','=','是');
    		}else{
    			$clients = $clients->whereNull('W');
    		}
    	}

    	$request->get('Ge')!==null && $clients = $clients->where('G','<=',$request->get('Ge'))->orWhere('G',null);
    	$request->get('Gs')!==null && $clients = $clients->where('G','>=',$request->get('Gs'));
    	

    	$request->get('Xe')!==null && $clients = $clients->where('X','<=',$request->get('Xe'))->orWhere('X',null);
    	$request->get('Xs')!==null && $clients = $clients->where('X','>=',$request->get('Xs'));

    	$request->get('Ye')!==null && $clients = $clients->where('Y','<=',$request->get('Ye'))->orWhere('Y',null);
    	$request->get('Ys')!==null && $clients = $clients->where('Y','>=',$request->get('Ys'));

    	$request->get('Ze')!==null && $clients = $clients->where('Z','<=',$request->get('Ze'))->orWhere('Z',null);
    	$request->get('Zs')!==null && $clients = $clients->where('Z','>=',$request->get('Zs'));

    	$request->get('AAe')!==null && $clients = $clients->where('AA','<=',$request->get('AAe'))->orWhere('AA',null);
    	$request->get('AAs')!==null && $clients = $clients->where('AA','>=',$request->get('AAs'));

    	$request->get('ABe')!==null && $clients = $clients->where('AB','<=',$request->get('ABe'))->orWhere('AB',null);
    	$request->get('ABs')!==null && $clients = $clients->where('AB','>=',$request->get('ABs'));

    	$request->get('ACe')!==null && $clients = $clients->where('AC','<=',$request->get('ACe'))->orWhere('AC',null);
    	$request->get('ACs')!==null && $clients = $clients->where('AC','>=',$request->get('ACs'));

    	$request->get('ADe')!==null && $clients = $clients->where('AD','<=',$request->get('ADe'))->orWhere('AD',null);
    	$request->get('ADs')!==null && $clients = $clients->where('AD','>=',$request->get('ADs'));

    	$order = Auth::user()->ord()->first();
        $str = (isset($order->cliStr) && $order->cliStr)?$order->cliStr:'updated_at';
        $ord = (isset($order->cliOrd) && $order->cliOrd)?$order->cliOrd:'desc';

        if($str == 'B' || $str == 'C'){
            $clients = $clients->orderByRaw("convert($str using gbk) $ord")->paginate(40);
        }else{
            $clients = $clients->orderBy($str,$ord)->paginate(40);
        }
        $order = ['str'=>$str,'ord'=>$ord];

    	return view('client.client',compact('clientTitles','clients','strArr','request','order'));

    }



    /*public function dig(){
    	for($i=0;$i<4900;$i++){
    		$data = [
    			'exam'=>mt_rand(0,100),
    			'class'=>mt_rand(0,3),
    			'err'=>mt_rand(0,100)/100,
    			'learn'=>mt_rand(0,500),
    		];
    		Dig::create($data);
    	};
    	
    }*/
}
