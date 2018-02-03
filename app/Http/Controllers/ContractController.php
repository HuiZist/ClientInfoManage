<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Excel;
use App\Client;
use App\Contract;
use App\ClientTitle;
use App\User;
use Carbon\Carbon;
use App\ContactBType;
use App\Remind;
use App\Ord;

class ContractController extends Controller
{
    //
    protected $subStr = [
    	'A','B','C','D','E','F','G','H',
    ];

    protected $cliStr = [
        'A','B','C','D','E','F','G',
        'H','I','J','K','L','M','N',
        'O','P','Q','R','S','T',
        'U','V','W','X','Y','Z',
        'AA','AB','AC','AD','AE','AF','AG',
        'AH','AI','AJ',
    ];

    public function getCon(){
    	if (Auth::user()->can('isAdmin')) {
		    return new Contract();
		}else{
			return Auth::user()->contracts();
		}
    }

    public function getStat($contracts){

    	$con = clone $contracts;

    	$operators = $con->distinct('operator_account')
    		->whereNotIn('operator_account',['notInClient','noAccount',''])
    		->select('operator_account','operator_name')
    		->get()->toArray();
    	foreach ($operators as $key => $value) {
    		$con = clone $contracts;
    		$operators[$key]['num'] = $con->where('operator_account',$value['operator_account'])->count();
    		$operators[$key]['cliNum'] = $con->where('operator_account',$value['operator_account'])->distinct('B')->count('B');
    	}

    	return $operators;
    }

    public function order(Request $request){
        $id = Auth::user()->id;
        $data = [
            "conStr"=>$request->get('str'),
            "conOrd"=>$request->get('ord'),
            "user_id"=>$id,
        ];
        Auth::user()->ord()->updateOrCreate(['user_id'=>$id],$data);
        return 1;
    }

    public function show(){
    	$contracts = $this->getCon();

    	$con = clone $contracts;

    	//客户数
    	$cliNum = $con->distinct('B')->count('B');
    	//记录数
    	$num = $con->count('id');
    	//分员工统计
    	$operators = $this->getStat($contracts);

    	$strArr = [];
    	$contractTitles = ClientTitle::find(2); 

    	//获取联系类型
    	$contactTypes = ContactBType::with(['stype'=>function($query){
            $query->orderBy('ord','desc');
        }])->orderBy('ord','desc')->get(); 

    	//获取contact列名
    	foreach ($this->subStr as $value) {
    		if(!!$contractTitles->$value){
    			array_push($strArr,$value);
    		}
    	}

        $order = Auth::user()->ord()->first();
        $str = (isset($order->conStr) && $order->conStr)?$order->conStr:'updated_at';
        $ord = (isset($order->conOrd) && $order->conOrd)?$order->conOrd:'desc';

        if($str == 'A'){
            $contracts = $contracts->orderByRaw("convert($str using gbk) $ord")->paginate(40);
        }else{
            $contracts = $contracts->orderBy($str,$ord)->paginate(40);
        }
        $order = ['str'=>$str,'ord'=>$ord];
    	//将日期截止到天
    	foreach ($contracts as $key => $value) {
    		$value->C = Carbon::parse($value->C)->toDateString();
    	}
    	
    	return view('contract.show',compact('contractTitles','contracts','strArr','cliNum','num','operators','contactTypes','order'));
        
    }

    public function select($contracts,$request){
        $request->get('A')!==null && $contracts = $contracts->where('A','like','%'.$request->get('A').'%');
        $request->get('B')!==null && $contracts = $contracts->where('B','like','%'.$request->get('B').'%');
        $request->get('F')!==null && $contracts = $contracts->where('F','like','%'.$request->get('F').'%');
        $request->get('G')!==null && $contracts = $contracts->where('G','like','%'.$request->get('G').'%');
        $request->get('H')!==null && $contracts = $contracts->where('H','like','%'.$request->get('H').'%');
        $request->get('operator_account')!==null && $contracts = $contracts->where('operator_account','like','%'.$request->get('operator_account').'%');
        $request->get('operator_name')!==null && $contracts = $contracts->where('operator_name','like','%'.$request->get('operator_name').'%');
        $request->get('sC')!==null && $contracts = $contracts->where('C','>=',$request->get('sC'));
        $request->get('eC')!==null && $contracts = $contracts->where('C','<=',$request->get('eC'));
        if(!!$request->get('D')){
            $D = $request->get('D');
            if(sizeof($D)==1){
                $contracts = $contracts->where('D','=',$D[0]);
            }else{
                $contracts = $contracts->whereIn('D',$D);
            }
        }
        return $contracts;
    }

    public function search(Request $request){

    	$contracts = $this->getCon();
        //当条件不为空时筛选
        $contracts = $this->select($contracts,$request);
        //深拷贝
        $con = clone $contracts;
    	//记录数
    	$num = $con->count('id');
    	//客户数
    	$cliNum = $con->distinct('B')->count('B');
    	//分员工统计
    	$operators = $this->getStat($contracts);

    	//获取联系类型
    	$contactTypes = ContactBType::with(['stype'=>function($query){
            $query->orderBy('ord','desc');
        }])->orderBy('ord','desc')->get();

    	//获取contact列名
        $strArr = [];
    	$contractTitles = ClientTitle::find(2); 
    	foreach ($this->subStr as $value) {
    		if(!!$contractTitles->$value){
    			array_push($strArr,$value);
    		}
    	}

        $order = Auth::user()->ord()->first();
        $str = (isset($order->conStr) && $order->conStr)?$order->conStr:'updated_at';
        $ord = (isset($order->conOrd) && $order->conOrd)?$order->conOrd:'desc';

        if($str == 'A'){
            $contracts = $contracts->orderByRaw("convert($str using gbk) $ord")->paginate(40);
        }else{
            $contracts = $contracts->orderBy($str,$ord)->paginate(40);
        }
        $order = ['str'=>$str,'ord'=>$ord];
        //将日期截止到天
    	foreach ($contracts as $key => $value) {
    		$value->C = Carbon::parse($value->C)->toDateString();
    	}

    	return view('contract.show',compact('contractTitles','contracts','strArr','cliNum','num','operators','contactTypes','request','order'));
        
    }

    public function link($cliId){

        $contracts = $this->getCon();
        $contracts = $contracts->where('B',$cliId);

        //深拷贝
        $con = clone $contracts;
        //记录数
        $num = $con->count('id');
        //客户数
        $cliNum = $con->distinct('B')->count('B');
        //分员工统计
        $operators = $this->getStat($contracts);

        //获取联系类型
        $contactTypes = ContactBType::with(['stype'=>function($query){
            $query->orderBy('ord','desc');
        }])->orderBy('ord','desc')->get();

        //获取contact列名
        $strArr = [];
        $contractTitles = ClientTitle::find(2); 
        foreach ($this->subStr as $value) {
            if(!!$contractTitles->$value){
                array_push($strArr,$value);
            }
        }

        $order = Auth::user()->ord()->first();
        $str = (isset($order->conStr) && $order->conStr)?$order->conStr:'updated_at';
        $ord = (isset($order->conOrd) && $order->conOrd)?$order->conOrd:'desc';

        if($str == 'A'){
            $contracts = $contracts->orderByRaw("convert($str using gbk) $ord")->paginate(40);
        }else{
            $contracts = $contracts->orderBy($str,$ord)->paginate(40);
        }
        $order = ['str'=>$str,'ord'=>$ord];
        //将日期截止到天
        foreach ($contracts as $key => $value) {
            $value->C = Carbon::parse($value->C)->toDateString();
        }
        return view('contract.show',compact('contractTitles','contracts','strArr','cliNum','num','operators','contactTypes','order'));
    }

    public function linkTc(Request $request){
        $contracts = $this->getCon();
        //当条件不为空时筛选
        $contracts = $this->select($contracts,$request);
        //提取不同客户资金账号
        $cliArr = $contracts->distinct('B')->select('B')->get()->toArray();

        $strArr = [];
        $clientTitles = ClientTitle::find(1);
        foreach ($this->cliStr as $value) {
            if(!!$clientTitles->$value){
                array_push($strArr,$value);
            }
        }
        if(isset($request->operator_account) && !!$request->operator_account){
            $clients = Client::where('A',$request->operator_account)->whereIn('D',$cliArr)->orWhereIn('E',$cliArr);
        }else{
            $clients = Client::whereIn('D',$cliArr)->orWhereIn('E',$cliArr);
        }

        $order = Auth::user()->ord()->first();
        $str = (isset($order->conStr) && $order->conStr)?$order->cliStr:'updated_at';
        $ord = (isset($order->conOrd) && $order->conOrd)?$order->cliOrd:'desc';

        if($str == 'B' || $str == 'C'){
            $clients = $clients->orderByRaw("convert($str using gbk) $ord")->paginate(40);
        }else{
            $clients = $clients->orderBy($str,$ord)->paginate(40);
        }
        $order = ['str'=>$str,'ord'=>$ord];

        $requestc = $request;

        return view('client.client',compact('clientTitles','clients','strArr','requestc','order'));
    }

    public function upload(Request $request){
    	if(!$request->hasFile('contractExcel')){
        	abort(500, '上传文件为空！');
	    } 
	    $file = $request->file('contractExcel');
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
		$filename = 'contract/'.date('Y-m-d').'-'.uniqid().'.'.$ext;
		Storage::disk('public')->put($filename,file_get_contents($realPath));
		$this->store($filename);
		return redirect()->route('contract.show');
    }

    public function store($filename){
    	$filePath = 'storage/'.iconv('UTF-8', 'GBK', $filename);
    	Excel::load($filePath, function($reader) {
    		//将Excel表数据转化为数组
	        $data = $reader->toArray();
	        //创建数组用于存储表头
	        $dataTitle = [];
	        $i = 0;
	        foreach($data[0] as $t=>$v){
	        	if(!!$t){
	        		if($i>=8){
	        			abort(500, 'Excel表头超过8列！');
	        		}
	        		$dataTitle[$this->subStr[$i]] = $t;
	        		$i++;
	        	}
	        }
	        //判断列名
	        if($dataTitle['A']!=='客户姓名'){
	        	abort(500, 'Excel表A列名称应为客户姓名！');
	        }
	        if($dataTitle['B']!=='资金账号'){
	        	abort(500, 'Excel表B列名称应为资金账号！');
	        }
	        if($dataTitle['C']!=='联系时间'){
	        	abort(500, 'Excel表C列名称应为联系时间！');
	        }
	        if($dataTitle['D']!=='联系类型'){
	        	abort(500, 'Excel表D列名称应为联系类型！');
	        }
	        //更新标题数据表
	        ClientTitle::find(2)->update($dataTitle);
	        //将数组格式化存入数据库
	        foreach ($data as $value) {
	        	$f = 0;
	        	$item = [];
	        	foreach ($value as $key => $val) {
	        		if(!!$key){
	        			$item[$this->subStr[$f]] = $val;
	        			$f++;
	        		}
	        	}
	        	if(!!$item['B']){
	        		$user = Client::where('D',$item['B'])->select('A','B')->first();
	        		if(!!$user){
	        			$item['operator_account'] = $user->A;
		        		$item['operator_name'] = $user->B;
	        		}else{
	        			$userf = Client::where('E',$item['B'])->select('A','B')->first();
	        			if(!!$userf){
	        				$item['operator_account'] = $userf->A;
		        			$item['operator_name'] = $userf->B;
	        			}else{
	        				$item['operator_account'] = 'notInClient';
		        			$item['operator_name'] = 'notInClient';
	        			}
	        		}
	        	}else{
	        		$item['operator_account'] = 'noAccount';
		        	$item['operator_name'] = 'noAccount';
	        	}
	        	Contract::create($item);
	        }
    	},'UTF-8');
    	return;
    }

    public function create(){
    	$nowDate = Carbon::now('Asia/ShangHai')->toDateString();
    	$contactTypes = ContactBType::with(['stype'=>function($query){
            $query->orderBy('ord','desc');
        }])->orderBy('ord','desc')->get();
    	return view('contract.create',compact('nowDate','contactTypes'));
    }

    public function add(Request $request){


    	$data = [
    		'A'=>$request->get('A'),
    		'B'=>$request->get('B'),
    		'C'=>$request->get('C'),
    		'D'=>$request->get('D'),
    		'E'=>$request->get('E'),
    		'F'=>$request->get('F'),
    		'G'=>$request->get('G'),
    		'H'=>$request->get('H'),
    		'operator_account'=>Auth::user()->account,
    		'operator_name'=>Auth::user()->name,
    	];

        if(!!$request->get('reTime')){
            $data['G'] = $data['G'].'提醒时间:'.$request->get('reTime');
        }
    	
    	$conId = Contract::create($data)->id;

    	if(!!$request->get('reTime')){
    		$remind = [
    		'user_id'=>Auth::user()->id,
    		'contact_id'=>$conId,
    		'reTime'=>$request->get('reTime'),
	    	];
	    	Remind::create($remind);
    	}
    	
    	return redirect()->route('contract.show'); 
    }

    public function delete($contactId){
    	//只有创建者或管理员有权限删除
    	$account = Contract::find($contactId)->operator_account;
    	$this->authorize('canEditorAccount', $account);

    	//将提醒时间删除
    	Remind::where('contact_id',$contactId)->delete();
    	Contract::destroy($contactId);
    	return redirect()->route('contract.show'); 
    }

    public function editor($contactId){
    	$t = Remind::where('contact_id',$contactId)->first();
    	$reTime = $t?$t->reTime:'';
    	$contactTypes = ContactBType::with(['stype'=>function($query){
            $query->orderBy('ord','desc');
        }])->orderBy('ord','desc')->get();
    	$contact = Contract::find($contactId);
    	$contact->C = Carbon::parse($contact->C)->toDateString();
    	return view('contract.editor',compact('contact','contactTypes','reTime','contactId'));
    }

    public function update(Request $request){
    	$contactId = $request->get('contactId');
    	$account = Contract::find($contactId)->operator_account;
    	$this->authorize('canEditorAccount', $account);

    	$data = [
    		'A'=>$request->get('A'),
    		'B'=>$request->get('B'),
    		'C'=>$request->get('C'),
    		'D'=>$request->get('D'),
    		'E'=>$request->get('E'),
    		'F'=>$request->get('F'),
    		'G'=>$request->get('G'),
    		'H'=>$request->get('H'),
    		'operator_account'=>Auth::user()->account,
    		'operator_name'=>Auth::user()->name,
    	];

        if(!!$request->get('reTime')){
            $data['G'] = $data['G'].'提醒时间:'.$request->get('reTime');
        }

        Contract::find($contactId)->update($data);

    	//删除remind表中该记录时间
    	Remind::where('contact_id',$contactId)->delete();

    	if(!!$request->get('reTime')){
    		$remind = [
	    		'user_id'=>Auth::user()->id,
	    		'contact_id'=>$contactId,
	    		'reTime'=>$request->get('reTime'),
	    	];
	    	Remind::create($remind);
    	}
    	
    	return redirect()->route('contract.show'); 
    }

    public function searchAct(Request $request){
        $clis = Client::where('C',$request->get('name'))->select('D','E')->get()->toArray();
        return json_encode($clis);
    }
}
