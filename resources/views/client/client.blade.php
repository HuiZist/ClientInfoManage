@extends('layouts.app')
@section('css')
<style type="text/css">
#clientNav>a{
	font-weight: bold;
	color:#000;
}
</style>
@endsection
@section('content')
<div id="client">
	<div class="container">
	@can('isAdmin')
    	<div class="btn-group btn-group-sm clientExcelImport" role="group">
    	
		  	<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
			  <i class="fa fa-sign-in"></i>&nbsp;&nbsp;客户总表导入
			</button>
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">请从本地选择Excel文件导入</h4>
			      </div>
			      <form method="POST" action="{{ route('client.upload') }}" enctype="multipart/form-data">
                   	<div class="modal-body">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <input type="file" name="clientExcel" id="clientExcel">
                        </div>
                        <p class="remind"><i class="fa fa-exclamation-circle"></i>&nbsp;请确认Excel文件中只有一个sheet，且数据行不超过1W！</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">导入</button>
                    </div>
                   </form>
			    </div>
			  </div>
			</div>

			<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm" id="trunBtn" disabled=true>
				<i class="fa fa-trash-o"></i>&nbsp;清空客户总表
			</button>
			<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="clientTruncate modal-content">
				    <div class="modal-footer">
				    	<p class="warn"><i class="fa fa-exclamation-triangle"></i>&nbsp;确定清空客户总表？</p>
	                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
	                    <a class="btn btn-primary" href="{{ route('client.truncate') }}">确定</a>
	              	</div>
              	</div>
			  </div>
			</div>
		    <input type="checkbox" id="trunSwitch">
		</div>
		@endcan
		<div class="clientTable">
			<div class="panel panel-default">
			  <!-- Default panel contents -->
			  <!-- <div class="panel-heading">Panel heading</div> -->
			  <div class="panel-body">
			  	<div class="form-group form-inline" style="margin-bottom:0;">
				  	<div class="input-group" style="width: 400px;">
					  	<span class="input-group-addon" id="sizing-addon2">排序方式</span>
					  	<select id="ordStr" class="form-control" aria-describedby="sizing-addon2">
							<option value="updated_at" {!! $order['str']=='updated_at'?'selected':'' !!}>更新时间</option>
							<option value="B" {!! $order['str']=='B'?'selected':'' !!}>员工姓名</option>
							<option value="C" {!! $order['str']=='C'?'selected':'' !!}>客户姓名</option>
							<option value="X" {!! $order['str']=='X'?'selected':'' !!}>潜在资产</option>
							<option value="Y" {!! $order['str']=='Y'?'selected':'' !!}>8月日均资金余额</option>
							<option value="Z" {!! $order['str']=='Z'?'selected':'' !!}>8月日均资产</option>
							<option value="AA" {!! $order['str']=='AA'?'selected':'' !!}>当年创收</option>
							<option value="AB" {!! $order['str']=='AB'?'selected':'' !!}>当年交易量</option>
							<option value="AC" {!! $order['str']=='AC'?'selected':'' !!}>周转率</option>
							<option value="AD" {!! $order['str']=='AD'?'selected':'' !!}>非现金资产仓位</option>
						</select>
						<span class="input-group-addon" id="sizing-addon3">顺序</span>
					  	<select id="ordOrd" class="form-control" aria-describedby="sizing-addon3">
							<option value="asc" {!! $order['ord']=='asc'?'selected':'' !!}>升序</option>
							<option value="desc" {!! $order['ord']=='desc'?'selected':'' !!}>降序</option>
						</select>
					</div>
					<button class="btn btn-primary" onclick="changeOrd()" style="display: inline-block;">排序</button>
					<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" 
			  		aria-expanded="false" aria-controls="collapseExample" style="float: right;">
				  搜索&nbsp;&nbsp;<i class="fa fa-caret-down"></i>
					</a>
			  	</div>
				<div class="collapse" id="collapseExample">
			  	<form class="form-inline" method="GET" action="{{ route('client.search') }}">
			  		<div class="form-group">
					    <input type="text" name="A" class="form-control" placeholder="员工号"
					    value="{!! isset($request)?$request->get('A'):'' !!}">
					    <input type="text" name="B" class="form-control" placeholder="员工姓名"
					    value="{!! isset($request)?$request->get('B'):'' !!}">
					    <input type="text" name="C" class="form-control" placeholder="客户姓名"
					    value="{!! isset($request)?$request->get('C'):'' !!}">
					    <input type="number" name="D" class="form-control" placeholder="资金账号"
					    value="{!! isset($request)?$request->get('D'):'' !!}">
					    <input type="number" name="E" class="form-control" placeholder="信用账号"
					    value="{!! isset($request)?$request->get('E'):'' !!}">
				    </div>

				    <div class="form-group">
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonF">开发/服务</span>
						    <select class="form-control" name="F" aria-describedby="basic-addonF">
						    	<option value="">不筛选</option>
						    	<option value="服务">服务</option>
						    	<option value="开发">开发</option>
						    	<option value="空">空</option>
						    	<option value="非空">非空</option>
						    </select>
					    </div>
					    <div class="input-group">
						    <span class="input-group-addon" id="basic-addonG">提成比例</span>
						    <input type="number" name="Gs" class="form-control" placeholder=">" 
						    aria-describedby="basic-addonG" step="any" value="{!! isset($request)?$request->get('Gs'):'' !!}">
					    </div>
					    <input type="number" name="Ge" class="form-control" placeholder="<" step="any" 
					    value="{!! isset($request)?$request->get('Ge'):'' !!}">
					    <input type="text" name="H" class="form-control" placeholder="风险等级" 
					    value="{!! isset($request)?$request->get('H'):'' !!}">
				    </div>

				    <div class="form-group">
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonI">新版App</span>
						    <select class="form-control" name="I" aria-describedby="basic-addonI">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonJ">创业板</span>
						    <select class="form-control" name="J" aria-describedby="basic-addonJ">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonK">投顾锦囊</span>
						    <select class="form-control" name="K" aria-describedby="basic-addonK">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonL">level2</span>
						    <select class="form-control" name="L" aria-describedby="basic-addonL">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonM">国债</span>
						    <select class="form-control" name="M" aria-describedby="basic-addonM">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
				    </div>

				    <div class="form-group">
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonN">货币冲量</span>
						    <select class="form-control" name="N" aria-describedby="basic-addonN">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonO">双鑫</span>
						    <select class="form-control" name="O" aria-describedby="basic-addonO">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonP">固收</span>
						    <select class="form-control" name="P" aria-describedby="basic-addonP">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonQ">权益</span>
						    <select class="form-control" name="Q" aria-describedby="basic-addonQ">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonR">基金定投</span>
						    <select class="form-control" name="R" aria-describedby="basic-addonR">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
				    </div>

				    <div class="form-group">
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonS">分级基金</span>
						    <select class="form-control" name="S" aria-describedby="basic-addonS">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
				    	<div class="input-group">
					    	<span class="input-group-addon" id="basic-addonT">信e融</span>
						    <select class="form-control" name="T" aria-describedby="basic-addonT">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonU">双融</span>
						    <select class="form-control" name="U" aria-describedby="basic-addonU">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonV">深港通</span>
						    <select class="form-control" name="V" aria-describedby="basic-addonV">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <div class="input-group">
					    	<span class="input-group-addon" id="basic-addonW">沪港通</span>
						    <select class="form-control" name="W" aria-describedby="basic-addonW">
						    	<option value="">不筛选</option>
						    	<option value="是">是</option>
						    	<option value="否">空</option>
						    </select>
					    </div>
					    <a class="btn btn-danger" href="{{ route('client.client') }}">清空搜索项</a>
				    </div>

				    <div class="form-group">
					    <div class="input-group">
						    <span class="input-group-addon" id="basic-addonX">潜在资产</span>
						    <input type="number" name="Xs" class="form-control" placeholder=">" 
						    aria-describedby="basic-addonX" step="any" style="width:110px;"
						    value="{!! isset($request)?$request->get('Xs'):'' !!}">
						    <input type="number" name="Xe" class="form-control" placeholder="<" step="any" style="width:110px;"
						    value="{!! isset($request)?$request->get('Xe'):'' !!}">
					    </div>

					    <div class="input-group">
						    <span class="input-group-addon" id="basic-addonY">8月日均资金余额(万)</span>
						    <input type="number" name="Ys" class="form-control" placeholder=">" 
						    aria-describedby="basic-addonY" step="any" style="width:110px;"
						    value="{!! isset($request)?$request->get('Ys'):'' !!}">
						    <input type="number" name="Ye" class="form-control" placeholder="<" step="any" style="width:110px;"
						    value="{!! isset($request)?$request->get('Ye'):'' !!}">
					    </div>

					    <div class="input-group">
						    <span class="input-group-addon" id="basic-addonZ">8月日均资产(万)</span>
						    <input type="number" name="Zs" class="form-control" placeholder=">" 
						    aria-describedby="basic-addonZ" step="any" style="width:110px;"
						    value="{!! isset($request)?$request->get('Zs'):'' !!}">
						    <input type="number" name="Ze" class="form-control" placeholder="<" step="any" style="width:110px;"
						    value="{!! isset($request)?$request->get('Ze'):'' !!}">
					    </div>
				    </div>

				    <div class="form-group">
					    <div class="input-group">
						    <span class="input-group-addon" id="basic-addonAA">当年创收(元)</span>
						    <input type="number" name="AAs" class="form-control" placeholder=">" 
						    aria-describedby="basic-addonAA" step="any" value="{!! isset($request)?$request->get('AAs'):'' !!}">
					    </div>
					    <input type="number" name="AAe" class="form-control" placeholder="<" step="any" 
					    value="{!! isset($request)?$request->get('AAe'):'' !!}">

					    <div class="input-group">
						    <span class="input-group-addon" id="basic-addonAB">当年交易量(万)</span>
						    <input type="number" name="ABs" class="form-control" placeholder=">" 
						    aria-describedby="basic-addonAB" step="any" value="{!! isset($request)?$request->get('ABs'):'' !!}">
					    </div>
					    <input type="number" name="ABe" class="form-control" placeholder="<" step="any" 
					    value="{!! isset($request)?$request->get('ABe'):'' !!}">
				    </div>

				    <div class="form-group">
					    <div class="input-group">
						    <span class="input-group-addon" id="basic-addonAC">周转率</span>
						    <input type="number" name="ACs" class="form-control" placeholder=">" 
						    aria-describedby="basic-addonAC" step="any" value="{!! isset($request)?$request->get('ACs'):'' !!}">
					    </div>
					    <input type="number" name="ACe" class="form-control" placeholder="<" step="any" 
					    value="{!! isset($request)?$request->get('ACe'):'' !!}">

					    <div class="input-group">
						    <span class="input-group-addon" id="basic-addonAD">非现金资产仓位</span>
						    <input type="number" name="ADs" class="form-control" placeholder=">" 
						    aria-describedby="basic-addonAD" step="any" value="{!! isset($request)?$request->get('ADs'):'' !!}">
					    </div>
					    <input type="number" name="ADe" class="form-control" placeholder="<" step="any" 
					    value="{!! isset($request)?$request->get('ADe'):'' !!}">
				   	</div>
					    
				    <div class="form-group">
				    	<button type="submit" class="btn btn-primary"><i class="fa fa-search">&nbsp;</i>查询</button>
				    </div>
				</form>
				</div>
				<button type="button" id="btnSpread" title="展开"><i class="fa fa-exchange"></i></button>
			  </div>
			  <div class="clientTableContent" id="clientTableContent">
			  <!-- Table -->
			  <table class="table table-bordered table-striped table-hover " id="clientTableBody">
			    <thead><tr>
				@foreach($strArr as $str)
					<th>{{ $clientTitles->$str }}</th>
				@endforeach
				</tr></thead>
				<tbody>
				@foreach($clients as $client)
					<tr>
						@foreach($strArr as $str)
							@if($str == 'C')
								<td><div class="cliTab{{ $str }}" title="{{ $client->$str }}">
								<a href="/client/link/{{ $client['D']?$client['D']:$client['E'] }}">{{ $client->$str }}</a>
								</div></td>
							@else
								<td><div class="cliTab{{ $str }}" title="{{ $client->$str }}">{{ $client->$str }}</div></td>
							@endif
						@endforeach
					</tr>
				@endforeach
				</tbody>
			  </table>
			  </div>
			</div>
		</div>
		<div class="page">
            @if(isset($request))
		    {!! $clients->appends([
		    	'A'=>$request->A,
		    	'B'=>$request->B,
		    	'C'=>$request->C,
		    	'D'=>$request->D,
		    	'E'=>$request->E,
		    	'F'=>$request->F,
		    	'Gs'=>$request->Gs,
		    	'Ge'=>$request->Ge,
		    	'H'=>$request->H,
		    	'I'=>$request->I,
		    	'J'=>$request->J,
		    	'K'=>$request->K,
		    	'L'=>$request->L,
		    	'M'=>$request->M,
		    	'N'=>$request->N,
		    	'O'=>$request->O,
		    	'P'=>$request->P,
		    	'Q'=>$request->Q,
		    	'R'=>$request->R,
		    	'S'=>$request->S,
		    	'T'=>$request->T,
		    	'U'=>$request->U,
		    	'V'=>$request->V,
		    	'W'=>$request->W,
		    	'Xs'=>$request->Xs,
		    	'Xe'=>$request->Xe,
		    	'Ys'=>$request->Ys,
		    	'Ye'=>$request->Ye,
		    	'Zs'=>$request->Zs,
		    	'Ze'=>$request->Ze,
		    	'AAs'=>$request->AAs,
		    	'AAe'=>$request->AAe,
		    	'ABs'=>$request->ABs,
		    	'ABe'=>$request->ABe,
		    	'ACs'=>$request->ACs,
		    	'ACe'=>$request->ACe,
		    	'ADs'=>$request->ADs,
		    	'ADe'=>$request->ADe,
		    	])->render() !!}
			@elseif(isset($requestc))
				{!! $clients->appends([
			    	'A'=>$requestc->A,
			    	'B'=>$requestc->B,
			    	'F'=>$requestc->F,
			    	'G'=>$requestc->G,
			    	'H'=>$requestc->H,
			    	'operator_account'=>$requestc->operator_account,
			    	'operator_name'=>$requestc->operator_name,
			    	'sC'=>$requestc->sC,
			    	'eC'=>$requestc->eC,
			    	'D'=>$requestc->D,
			    	'operator_account'=>$requestc->operator_account,
			    	])->render() !!}
			@else
				{{ $clients->links() }}
			@endif
        </div>
        <div id="bottom" name="bottom"></div>
        <div class="appLocation btn-group-vertical" role="group">
        	<a class="btn btn-default" href="#top"><i class="fa fa-chevron-up"></i></i></a>
        	<a class="btn btn-default" href="#bottom"><i class="fa fa-chevron-down"></i></a>
        </div>

	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){
	//扩展键切换客户总表状态
	$("#btnSpread").click(function(){
		if($("#clientTableBody").hasClass("tableSpread")){
			$("#btnSpread").html("<i class='fa fa-exchange'></i>");
			$("#btnSpread").css("background","#c33");
			$("#btnSpread").attr("title","展开");
			$("#clientTableContent").css("overflow-x","auto");
		}else{
			$("#btnSpread").html("<i class='fa fa-reply-all'></i>");
			$("#btnSpread").css("background","#3097D1");
			$("#btnSpread").attr("title","收缩");
			$("#clientTableContent").css("overflow-x","visible");
		}
		$("#clientTableBody").toggleClass("tableSpread");
	});
	$("#trunSwitch").click(function(){
		if($("#trunSwitch").is(':checked')){
			$("#trunBtn").attr("disabled",false);
		}else{
			$("#trunBtn").attr("disabled",true);
		}
	});
	
});
function changeOrd(){
	var str = $("#ordStr option:selected").val();
	var ord = $("#ordOrd option:selected").val();
	$.ajax({
		type:"POST",
		url:"/client/order",
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
</script>
@endsection
