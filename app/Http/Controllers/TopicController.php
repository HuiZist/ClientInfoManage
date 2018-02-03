<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTopicRequest;
use Excel;
use App\Topic;
use App\User;
use Carbon\Carbon;
use StdClass;

class TopicController extends Controller
{
    //
    protected $subStr = [
    	'A','B','C','D',
    ];

    public function show(){
    	$topics = Topic::orderBy('updated_at','desc')->paginate(20);
    	return view('topic.show',compact('topics'));
    }

    public function search(Request $request){
    	/*dd($request->get('content'));*/
        $topics = new Topic();
        //当条件不为空时筛选
        $request->get('product_type')!==null && $topics = $topics->where('product_type','like','%'.$request->get('product_type').'%');
        $request->get('topic_type')!==null && $topics = $topics->where('topic_type','like','%'.$request->get('topic_type').'%');
        $request->get('source')!==null && $topics = $topics->where('source','like','%'.$request->get('source').'%');
        $request->get('content')!==null && $topics = $topics->where('content','like','%'.$request->get('content').'%');

        $topics = $topics->orderBy('updated_at','desc')->paginate(20);
    	
    	return view('topic.show',compact('topics','request'));
    }

    public function upload(Request $request){
    	if(!$request->hasFile('topicExcel')){
        	abort(500, '上传文件为空！');
	    } 
	    $file = $request->file('topicExcel');
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
		$filename = 'topic/'.date('Y-m-d').'-'.uniqid().'.'.$ext;
		Storage::disk('public')->put($filename,file_get_contents($realPath));
		$this->store($filename);
		return redirect()->route('topic.show');
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
	        		if($i>=4){
	        			abort(500, 'Excel表头超过4列！');
	        		}
	        		$dataTitle[$this->subStr[$i]] = $t;
	        		$i++;
	        	}
	        }
	        if($dataTitle['A']!=='产品类型'){
	        	abort(500, 'Excel表A列名称应为产品类型！');
	        }
	        if($dataTitle['B']!=='话术类型'){
	        	abort(500, 'Excel表B列名称应为话术类型！');
	        }
	        if($dataTitle['C']!=='话术来源'){
	        	abort(500, 'Excel表C列名称应为话术来源！');
	        }
	        if($dataTitle['D']!=='话术详情'){
	        	abort(500, 'Excel表D列名称应为话术详情！');
	        }
	        
	        //将数组格式化存入数据库
	        foreach ($data as $value) {
	        	$item = [];
	        	foreach ($value as $k => $v) {
	        		array_push($item,$v);
	        	}
	        	$topic = [];
	        	$topic['product_type'] = $item[0];
	        	$topic['topic_type'] = $item[1];
	        	$topic['source'] = $item[2];
	        	$topic['content'] = $item[3];
	        	Topic::create($topic);
	        }
    	},'UTF-8');
    	return;
    }

    public function create(StoreTopicRequest $request){
        $user = User::where('id',Auth::id())->select('account','name')->first();
    	$data = [
            'post_account'=>$user->account,
            'post_name'=>$user->name,
    		'product_type'=>$request->get('product_type'),
    		'topic_type'=>$request->get('topic_type'),
    		'source'=>$request->get('source'),
    		'content'=>$request->get('content'),
    	];
    	Topic::create($data);
    	return redirect()->route('topic.show');
    }

    public function destory($topicId){
        //获取作者账号判断权限
        $account = Topic::find($topicId)->post_account;
        $this->authorize('canEditorAccount', $account);

    	Topic::destroy($topicId);
    	return redirect()->route('topic.show');
    }

    public function editorView($topicId){
    	$topic = Topic::find($topicId);
    	return view('topic.editor',compact('topic','topicId'));
    }

    public function editor(StoreTopicRequest $request){
        //获取作者账号判断权限
        $account = Topic::find($request->get('topicId'))->post_account;
        $this->authorize('canEditorAccount', $account);

        $user = User::where('id',Auth::id())->select('account','name')->first();
    	$data = [
            'post_account'=>$user->account,
            'post_name'=>$user->name,
    		'product_type'=>$request->get('product_type'),
    		'topic_type'=>$request->get('topic_type'),
    		'source'=>$request->get('source'),
    		'content'=>$request->get('content'),
    	];
    	Topic::find($request->get('topicId'))->update($data);
    	return redirect()->route('topic.show');
    }
}
