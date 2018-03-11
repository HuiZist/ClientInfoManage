@extends('layouts.app')
@section('css')
<style type="text/css">
#contractNav>a{
	font-weight: bold;
	color:#000;
}
</style>
@endsection
@section('content')
<div id="contract">
<div class="container">
	<div class="btn-group btn-group-sm contractExcelImport" role="group">
		@can("isAdmin")
	  	<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
		  <i class="fa fa-sign-in"></i>&nbsp;&nbsp;联系表导入
		</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">请从本地选择Excel文件导入</h4>
		      </div>
		      <form method="POST" action="{{ route('contract.upload') }}" enctype="multipart/form-data">
	           	<div class="modal-body">
	                {!! csrf_field() !!}
	                <div class="form-group">
	                    <input type="file" name="contractExcel" id="contractExcel">
	                </div>
	                <p class="remind"><i class="fa fa-exclamation-circle"></i>&nbsp;请确认Excel文件中只有一个sheet，数据行不超过1W，且表头正确！</p>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
	                <button type="submit" class="btn btn-primary">
	                	导入
	                </button>
	            </div>
	           </form>
		    </div>
		  </div>
		</div>
		@endcan
		<a class="btn btn-primary" href="{{ route('contract.create') }}">
		<i class="fa fa-edit"></i>&nbsp;&nbsp;添加联系记录
		</a>
		<div id="message" class="panel panel-info">
			<div class="panel-heading"><i class="fa fa-bell-o">&nbsp;&nbsp;</i>消息提醒</div>
			<div class="panel-body">
				<table class="table">
					<thead>
					<tr><th>########</th><th>信息</th></tr>
					</thead>
					<tbody><tr><td>客户名</td><td id="iA"></td></tr>
					<tr><td>资金账号</td><td id="iB"></td></tr>
					<tr><td>联系时间</td><td id="iC"></td></tr>
					<tr><td>潜在</td><td id="iF"></td></tr>
					<tr><td>联系类型</td><td id="iD"></td></tr>
					<tr><td>沟通反馈</td><td id="iE"></td></tr>
					<tr><td>下一步计划</td><td id="iG"></td></tr>
					<tr><td>购买结果</td><td id="iH"></td></tr>
					</tbody>
				</table>
			</div>
			<div class="panel-footer">
				<button class="btn btn-info" onclick="messageClose()">收到</button>
			</div>
		</div>

	</div>
	<div class="contractTable">
		<div class="panel panel-default">
		  <!-- Default panel contents -->
		  <!-- <div class="panel-heading">Panel heading</div> -->
		  <div class="panel-body">
		  	<form method="GET" class="form-inline" action="{{ route('contract.search') }}">
		  	{!! csrf_field() !!}
		  		<div class="form-group" style="margin-bottom: 10px;">
				    <input type="text" name="A" class="form-control" placeholder="客户姓名" 
				    style="width:100px;" value="{!! isset($request)?$request->get('A'):'' !!}" >
				    <input type="number" name="B" class="form-control" placeholder="资金账号"
				    value="{!! isset($request)?$request->get('B'):'' !!}">
				    <div class="input-group">
						<span class="input-group-addon" id="basic-addon3">起始时间</span>
				  		<input type="text" name="sC" class="date form-control" aria-describedby="basic-addon3"
				  			value="{!! isset($request)?$request->get('sC'):'' !!}">
				  		<span class="input-group-addon" id="basic-addon5">截止时间</span>
				  		<input type="text" name="eC" class="date form-control" aria-describedby="basic-addon5"
				  			value="{!! isset($request)?$request->get('eC'):'' !!}">
			  		</div>
			  		<div class="input-group">
						<span class="input-group-addon" id="basic-addon4">联系类型</span>
					    <select class="js-example-basic-multiple js-states form-control" name="D[]" multiple="multiple"  
					    aria-describedby="basic-addon4" style="width:200px;">
						  	@foreach($contactTypes as $btype)
								<optgroup label="{{ $btype->name }}" title="{{ $btype->detail }}">
								@foreach($btype->stype as $stype)
									@if(isset($request) && !!$request->get('D'))
										@if(in_array($btype->name.'（'.$stype->name.'）',$request->get('D')))
										<option value="{!!  $btype->name.'（'.$stype->name.'）' !!}" title="{{ $stype->detail }}" selected>
											{!!  $btype->name.'（'.$stype->name.'）' !!}
										</option>
										@else
										<option value="{!!  $btype->name.'（'.$stype->name.'）' !!}" title="{{ $stype->detail }}">
											{!!  $btype->name.'（'.$stype->name.'）' !!}
										</option>
										@endif
									@else
									<option value="{!!  $btype->name.'（'.$stype->name.'）' !!}" title="{{ $stype->detail }}">
										{!!  $btype->name.'（'.$stype->name.'）' !!}
									</option>
									@endif
								@endforeach
								</optgroup>
							@endforeach
						</select>
					</div>
			    </div>
			    <div class="form-group" style="margin-bottom: 10px;">
			    	<input type="text" name="E" class="form-control" placeholder="沟通反馈"
				    value="{!! isset($request)?$request->get('E'):'' !!}" title="查询非空请输入%">
				    <div class="input-group">
						<span class="input-group-addon" id="basic-addon6">潜在/拒绝/不置</span>
					  	<select class="js-states form-control" name="F" id="id_label_single" 
						aria-describedby="basic-addon6" style="width: 120px;">
							<option value="" {!! isset($request) && ($request->get('F') == '')?'selected':'' !!}>不筛选</option>
							<option value="潜在" {!! isset($request) && ($request->get('F') == '潜在')?'selected':'' !!}>潜在</option>
							<option value="拒绝" {!! isset($request) && ($request->get('F') == '拒绝')?'selected':'' !!}>拒绝</option>
							<option value="不置可否" {!! isset($request) && ($request->get('F') == '不置可否')?'selected':'' !!}>不置可否</option>
						</select>
					</div>
			    	<!-- <input type="text" name="F" class="form-control" placeholder="潜在/拒绝/不置可否" 
			    					    style="width:100px;" value="{!! isset($request)?$request->get('F'):'' !!}"> -->
				    <input type="text" name="G" class="form-control" placeholder="下一步计划"
				    value="{!! isset($request)?$request->get('G'):'' !!}" title="查询非空请输入%">
				    <input type="text" name="H" class="form-control" placeholder="购买结果"
				    value="{!! isset($request)?$request->get('H'):'' !!}" title="查询非空请输入%">
			    	<input type="text" name="operator_account" class="form-control" placeholder="员工号" 
			    	style="width:100px;" value="{!! isset($request)?$request->get('operator_account'):'' !!}">
			    	<input type="text" name="operator_name" class="form-control" placeholder="员工" 
			    	style="width:100px;" value="{!! isset($request)?$request->get('operator_account'):'' !!}">
			    	<button type="submit" class="btn btn-primary"><i class="fa fa-search">&nbsp;</i>查询</button>
			    	<a class="btn btn-danger" href="{{ route('contract.show') }}">清空</a>
			    </div>
			</form>
			<div class="form-group form-inline" style="margin-bottom:0;">
				<div class="input-group" style="width: 400px;">
				  	<span class="input-group-addon" id="sizing-addon2">排序方式</span>
				  	<select id="ordStr" class="form-control" aria-describedby="sizing-addon2">
						<option value="updated_at" {!! $order['str']=='updated_at'?'selected':'' !!}>更新时间</option>
						<option value="C" {!! $order['str']=='C'?'selected':'' !!}>联系时间</option>
						<option value="A" {!! $order['str']=='A'?'selected':'' !!}>客户姓名</option>
					</select>
					<span class="input-group-addon" id="sizing-addon3">顺序</span>
				  	<select id="ordOrd" class="form-control" aria-describedby="sizing-addon3">
						<option value="asc" {!! $order['ord']=='asc'?'selected':'' !!}>升序</option>
						<option value="desc" {!! $order['ord']=='desc'?'selected':'' !!}>降序</option>
					</select>
				</div>
				<button class="btn btn-primary" onclick="changeOrd()" style="display: inline-block;">排序</button>
	  		</div>
	  	</div>

		  <div class="contractTableContent">
		  <!-- Table -->
		  <table class="table table-bordered table-striped table-hover" >
		    <thead><tr>
			@foreach($strArr as $str)
				<th>{{ $contractTitles->$str }}</th>
			@endforeach
				<th>员工号</th>
				<th>员工</th>
				<th>操作</th>
			</tr></thead>
			<tbody>
			@foreach($contracts as $contract)
				<tr>
					@foreach($strArr as $str)
						@if($str == 'E' || $str == 'G' || $str == 'H')
							<td><div class="contract{{$str}}"><span class="tip" title="{{ $contract->$str }}">{{ $contract->$str }}</span></div></td>
						@else
							<td><div class="contract{{$str}}" title="{{ $contract->$str }}">{{ $contract->$str }}</div></td>
						@endif
					@endforeach
						<td><div class="contractOperatorAccount" title="{{ $contract->operator_account }}">{{ $contract->operator_account }}</div></td>
						<td><div class="contractOperatorName" title="{{ $contract->operator_name }}">{{ $contract->operator_name }}</div></td>
						<td>
						@can('canEditorAccount',$contract->operator_account)
						<div class="btn-group">
							<a class="btn btn-sm btn-danger" href="/contact/delete/{{ $contract->id }}" onclick="return confirm('确定删除该联系记录？');" title="删除">
							<i class="fa fa-trash-o"></i>
							</a>
							<a class="btn btn-sm btn-primary" href="/contact/editor/{{ $contract->id }}" title="编辑">
							<i class="fa fa-pencil"></i>
							</a>
						</div>
						@endcan
						</td>
				</tr>
			@endforeach
			</tbody>
		  </table>
		  </div>
		</div>
	</div>
	<div class="page">
    @if(isset($request))
    {!! $contracts->appends([
    	'A'=>$request->A,
    	'B'=>$request->B,
    	'E'=>$request->E,
    	'F'=>$request->F,
    	'G'=>$request->G,
    	'H'=>$request->H,
    	'operator_account'=>$request->operator_account,
    	'operator_name'=>$request->operator_name,
    	'sC'=>$request->sC,
    	'eC'=>$request->eC,
    	'D'=>$request->D,
    	])->render() !!}
	@else
		{{ $contracts->links() }}
	@endif
    </div>
    <div class="panel panel-primary">
  	<div class="panel-heading"><i class="fa fa-bar-chart">&nbsp;</i>当前筛选统计</div>
	  	<div class="panel-body statTable">
	    <table class="table table-bordered table-striped table-hover" >
		    <tbody>
		    <tr><th>员工号</th><th>员工姓名</th><th>不同客户数:
		    @if(isset($request))
			    <a href="{{ route('contract.linkTc',array(
			    'A'=>$request->A,
			    'B'=>$request->B,
			    'E'=>$request->E,
			    'F'=>$request->F,
			    'G'=>$request->G,
			    'H'=>$request->H,
			    'operator_account'=>$request->operator_account,
			    'operator_name'=>$request->operator_name,
			    'sC'=>$request->sC,
			    'eC'=>$request->eC,
			    'D'=>$request->D)) 
			    }}" style="color: white;">
			    	{{ $cliNum }}
			    </a>
		   	@else
		   		<a href="{{ route('contract.linkTc') }}" style="color: white;">
			    	{{ $cliNum }}
			    </a>
		    @endif
		    </th><th>记录总数:{{ $num }}</th></tr>
		    @foreach($operators as $okey=>$oval)
		    <tr>
			    <td>{{ $oval['operator_account'] }}</td>
			    <td>{{ $oval['operator_name'] }}</td>
			    <td>
			    @if(isset($request))
				    <a href="{{ route('contract.linkTc',array(
				    'A'=>$request->A,
				    'B'=>$request->B,
				    'E'=>$request->E,
				    'F'=>$request->F,
				    'G'=>$request->G,
				    'H'=>$request->H,
				    'operator_account'=>$request->operator_account,
				    'operator_name'=>$request->operator_name,
				    'sC'=>$request->sC,
				    'eC'=>$request->eC,
				    'D'=>$request->D,
				    'operator_account'=>$oval['operator_account'],
				    )) 
				    }}">
				    	{{ $oval['cliNum'] }}
				    </a>
			    @else
			    	<a href="{{ route('contract.linkTc',array('operator_account'=>$oval['operator_account'],)) }}">
			    		{{ $oval['cliNum'] }}
		    		</a>
			    @endif
			    </td>
			    <td>{{ $oval['num'] }}</td>
		    </tr>
		    @endforeach
		    </tbody>
	    </table>
	  	</div>
	</div>
    
    <div id="bottom" name="bottom"></div>
    <div class="appLocation btn-group-vertical" role="group">
    	<a class="btn btn-default" href="#top"><i class="fa fa-chevron-up"></i></a>
    	<a class="btn btn-default" href="#bottom"><i class="fa fa-chevron-down"></i></a>
    </div>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
    $('.date').each(function(){
        $(this).ionDatePicker({
            lang: 'zh-cn',
            format: 'YYYY-MM-DD'
        });
    });
    $.ajax({
		type:"POST",
		url:"/remind",
		data:{},
		dataType: "json",
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success:function(data){
			if(!!data){
				$("#message #iA").html(data['A']);
				$("#message #iB").html(data['B']);
				$("#message #iC").html(data['C']);
				$("#message #iD").html(data['D']);
				$("#message #iE").html(data['E']);
				$("#message #iF").html(data['F']);
				$("#message #iG").html(data['G']);
				$("#message #iH").html(data['H']);
				$("#message").slideDown();
			}
		},
		error:function(){
			alert('排序数据提交失败！');
		},
	})
});
function changeOrd(){
	var str = $("#ordStr option:selected").val();
	var ord = $("#ordOrd option:selected").val();
	$.ajax({
		type:"POST",
		url:"/contact/order",
		data:{'str':str,'ord':ord},
		dataType: "json",
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success:function(data){
			window.location.reload();
		},
		error:function(){
			alert('排序数据提交失败！');
		},
	})

}
function messageClose(){
	$("#message").slideUp();
}
</script>
@endsection