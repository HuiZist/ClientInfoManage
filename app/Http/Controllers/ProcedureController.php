<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProcedureRequest;
use Excel;
use App\Procedure;
use App\User;
use Carbon\Carbon;
use App\Supple;

class ProcedureController extends Controller
{
    //
    protected $subStr = [
    	'A','B','C','D','E'
    ];

    public function show(){
    	$proces = Procedure::with(['supples'	=> function($query){
    		$query->orderBy('updated_at','desc');
			}])
    	->orderBy('updated_at','desc')->paginate(20);
    	return view('procedure.show',compact('proces'));
    }

    public function search(Request $request){
    	/*dd($request->get('content'));*/

    	$proces = Procedure::with(['supples' => function($query){
    		$query->orderBy('updated_at','desc');
			}]);
        $request->get('post_name')!==null && $proces = $proces->where('post_name','like','%'.$request->get('post_name').'%');
        $request->get('btype')!==null && $proces = $proces->where('btype','like','%'.$request->get('btype').'%');
        $request->get('stype')!==null && $proces = $proces->where('stype','like','%'.$request->get('stype').'%');
        $request->get('content')!==null && $proces = $proces->where('content','like','%'.$request->get('content').'%');

        $proces = $proces->orderBy('updated_at','desc')->paginate(20);
    	
    	return view('procedure.show',compact('proces','request'));
    }

    public function upload(Request $request){
    	if(!$request->hasFile('procedureExcel')){
        	abort(500, '上传文件为空！');
	    } 
	    $file = $request->file('procedureExcel');
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
		$filename = 'procedure/'.date('Y-m-d').'-'.uniqid().'.'.$ext;
		Storage::disk('public')->put($filename,file_get_contents($realPath));
		$this->store($filename);
		return redirect()->route('procedure.show');
    }

    public function store($filename){
    	$filePath = 'storage/'.iconv('UTF-8', 'GBK', $filename);
    	Excel::load($filePath, function($reader) {
    		//将Excel表数据转化为数组
	        $data = $reader->toArray();
	        //判断列名
	        $dataTitle = [];
	        $i = 0;
	        foreach($data[0] as $t=>$v){
	        	if(!!$t){
	        		if($i>=5){
	        			abort(500, 'Excel表头超过5列！');
	        		}
	        		$dataTitle[$this->subStr[$i]] = $t;
	        		$i++;
	        	}
	        }
	        if($dataTitle['A']!=='添加时间'){
	        	abort(500, 'Excel表A列名称应为添加时间！');
	        }
	        if($dataTitle['B']!=='添加人员'){
	        	abort(500, 'Excel表B列名称应为添加人员！');
	        }
	        if($dataTitle['C']!=='业务大类'){
	        	abort(500, 'Excel表C列名称应为业务大类！');
	        }
	        if($dataTitle['D']!=='业务小类'){
	        	abort(500, 'Excel表D列名称应为业务小类！');
	        }
	        if($dataTitle['E']!=='详细描述'){
	        	abort(500, 'Excel表D列名称应为详细描述！');
	        }

	        //将数组格式化存入数据库
	        foreach ($data as $value) {
	        	$item = [];
	        	foreach ($value as $k => $v) {
	        		array_push($item,$v);
	        	}
	        	$proce = [];
	        	$proce['post_time'] = $item[0];
	        	$proce['post_name'] = $item[1];
	        	$proce['btype'] = $item[2];
	        	$proce['stype'] = $item[3];
	        	$proce['content'] = $item[4];
	        	Procedure::create($proce);
	        }
    	},'UTF-8');
    	return;
    }

    public function create(StoreProcedureRequest $request){
    	$nowt = Carbon::now('Asia/ShangHai')->toDateTimeString();
    	$user = User::where('id',Auth::id())->select('name','account')->first();
    	$data = [
    		'post_time'=>$nowt,
    		'post_name'=>$user->name,
    		'post_account'=>$user->account,
    		'btype'=>$request->get('btype'),
    		'stype'=>$request->get('stype'),
    		'content'=>$request->get('content'),
    	];
    	Procedure::create($data);
    	return redirect()->route('procedure.show');
    }

    public function destory($proceId){
    	//获取作者账号判断权限
    	$account = Procedure::find($proceId)->post_account;
    	$this->authorize('canEditorAccount', $account);
    	//删除对应补充
    	Supple::where('pro_id',$proceId)->delete();
    	Procedure::destroy($proceId);
    	return redirect()->route('procedure.show');
    }

    public function editorView($proceId){
    	$procedure = Procedure::find($proceId);
    	return view('procedure.editor',compact('procedure','proceId'));
    }

    public function editor(StoreProcedureRequest $request){
    	//获取作者账号判断权限
    	$account = Procedure::find($request->get('proceId'))->post_account;
    	$this->authorize('canEditorAccount', $account);
    	
    	$user = User::where('id',Auth::id())->select('name','account')->first();
    	$data = [
    		'post_time'=>$request->get('post_time'),
    		'post_name'=>$user->name,
    		'post_account'=>$user->account,
    		'btype'=>$request->get('btype'),
    		'stype'=>$request->get('stype'),
    		'content'=>$request->get('content'),
    	];
    	Procedure::find($request->get('proceId'))->update($data);
    	return redirect()->route('procedure.show');
    }

}
