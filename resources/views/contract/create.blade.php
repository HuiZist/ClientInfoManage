@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div id="contactCreate">
<div class="container">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">联系记录创建</h3>
	  </div>
	  <div class="panel-body">
	    <form method="POST" action="{{ route('contract.add') }}">
		{!! csrf_field() !!}
		<div class="form-group">
        	<div class="input-group" style="width: 700px;">
			  <span class="input-group-addon" id="basic-addon1">客户姓名</span>
			  <input type="text" name="A" class="form-control" id="A" placeholder="" aria-describedby="basic-addon1">
			  <span class="input-group-addon" id="basic-addon2">资金账号</span>
			  <input type="number" name="B" id="cliAcc" class="form-control" placeholder="" aria-describedby="basic-addon2">
			  <span class="input-group-addon">
			  	<button type="button" onclick="searchAct()"><i class="fa fa-search"></i></button>
			  </span>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon4">联系类型</span>
				<select class="js-example-basic-single form-control" name="D" aria-describedby="basic-addon4">
				@foreach($contactTypes as $btype)
					<optgroup label="{{ $btype->name }}" title="{{ $btype->detail }}">
					@foreach($btype->stype as $stype)
						<option value="{!!  $btype->name.'（'.$stype->name.'）' !!}" title="{{ $stype->detail }}">
							{!!  $btype->name.'（'.$stype->name.'）' !!}
						</option>
					@endforeach
					</optgroup>
				@endforeach
				</select>
			</div>
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">联系时间</span>
			  	<input type="text" name="C" class="date form-control" aria-describedby="basic-addon3" value="{{ $nowDate }}">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon5">沟通过程及客户反馈</span>
				<textarea rows="3" class="form-control" name="E" aria-describedby="basic-addon5"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon6">潜在/拒绝/不置可否</span>
			  	<select class="js-example-basic-multiple js-states form-control" name="F" id="id_label_single" 
				aria-describedby="basic-addon6" style="width: 120px;">
					<option value="">空</option>
					<option value="潜在">潜在</option>
					<option value="拒绝">拒绝</option>
					<option value="不置可否">不置可否</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon7">下一步计划</span>
				<textarea rows="3" class="form-control" name="G" aria-describedby="basic-addon7"></textarea>
				
			</div>
		</div>
		<div class="form-group" style="width:400px;">
			<div class="input-group">
			<span class="input-group-addon" id="basic-addon8">下一次联系时间</span>
			  	<input type="text" name="reTime" class="date form-control" placeholder="如需要到期提醒则填写" aria-describedby="basic-addon8">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon9">购买结果</span>
				<textarea rows="3" class="form-control" name="H" aria-describedby="basic-addon9" placeholder="请填入代码和金额"></textarea>
				
			</div>
		</div>
		<div class="form-group">
	        <button type="submit" class="btn btn-primary">提交</button>
	    </div>
		</form>
	  </div>
	  <div class="panel-footer" id="searchShow">
	  </div>
	</div>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
	$('.date').each(function(){
        $(this).ionDatePicker({
            lang: 'zh-cn',
            format: 'YYYY-MM-DD'
        });
    });
    $('.js-example-basic-single').select2();
});
function searchAct(){
	var name = $("#A").val();
	$.ajax({
		type:"POST",
		url:"/contact/searchAct",
		data:{'name':name},
		dataType: "json",
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success:function(data){
			if(!!data[0]){
				if(!!data[0]['D']){
					$("#cliAcc").val(data[0]['D']);
				}else if(!!data[0]['E']){
					$("#cliAcc").val(data[0]['E']);
				}
				str = "账号搜索结果:</br>";
				data.forEach(function(item,index,array){
					 str +=  '账号'+index+'————资金账号：'+item['D']+"&nbsp;&nbsp;信用账号："+item['E']+"</br>";
				})
				$("#searchShow").html(str);
			}
		},
		error:function(){
			alert('数据提交失败！');
		},
	})

}
</script>
@endsection