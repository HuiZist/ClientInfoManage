@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div id="contactEditor">
<div class="container">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">联系记录编辑</h3>
	  </div>
	  <div class="panel-body">
	    <form method="POST" action="{{ route('contract.update') }}">
		{!! csrf_field() !!}
		<input type="hidden" name="contactId" value="{{ $contactId }}">
		<div class="form-group">
        	<div class="input-group">
			  <span class="input-group-addon" id="basic-addon1">客户姓名</span>
			  <input type="text" name="A" class="form-control" value="{{ $contact->A }}" aria-describedby="basic-addon1">
			  <span class="input-group-addon" id="basic-addon2">资金账号</span>
			  <input type="number" name="B" class="form-control" value="{{ $contact->B }}" aria-describedby="basic-addon2">
		  	</div>
		</div>
		<div class="form-group form-inline">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon4">联系类型</span>
				<select class="js-example-basic-single form-control" name="D" id="id_label_single" 
				aria-describedby="basic-addon4">
				@foreach($contactTypes as $btype)
					<optgroup label="{{ $btype->name }}" title="{{ $btype->detail }}">
					@foreach($btype->stype as $stype)
						<option value="{!!  $btype->name.'（'.$stype->name.'）' !!}" title="{{ $stype->detail }}" 
						{!! $btype->name.'（'.$stype->name.'）' == $contact->D?'selected':'' !!}>
							{!!  $btype->name.'（'.$stype->name.'）' !!}
						</option>
					@endforeach
					</optgroup>
				@endforeach
				</select>
			</div>
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">联系时间</span>
			  	<input type="text" name="C" class="date form-control" aria-describedby="basic-addon3" value="{{ $contact->C }}">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon5">沟通过程及客户反馈</span>
				<textarea rows="3" class="form-control" name="E" aria-describedby="basic-addon5">{{ $contact->E }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon6">潜在/拒绝/不置可否</span>
			  	<select class="js-example-basic-multiple js-states form-control" name="F" id="id_label_single" 
				aria-describedby="basic-addon6" style="width: 120px;">
					<option value="" {!! $contact->F==''?'selected':'' !!}>空</option>
					<option value="潜在" {!! $contact->F=='潜在'?'selected':'' !!}>潜在</option>
					<option value="拒绝" {!! $contact->F=='拒绝'?'selected':'' !!}>拒绝</option>
					<option value="不置可否" {!! $contact->F=='不置可否'?'selected':'' !!}>不置可否</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon7">下一步计划</span>
				<textarea rows="3" class="form-control" name="G" aria-describedby="basic-addon7">{{ $contact->G }}</textarea>
				
			</div>
		</div>
		<div class="form-group" style="width:400px;">
			<div class="input-group">
			<span class="input-group-addon" id="basic-addon8">下一次联系时间</span>
			  	<input type="text" name="reTime" class="date form-control" placeholder="如需要到期提醒则填写" 
			  	aria-describedby="basic-addon8" value="{{ $reTime }}">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon9">购买结果</span>
				<textarea rows="3" class="form-control" name="H" aria-describedby="basic-addon9">{{ $contact->H }}</textarea>
			</div>
		</div>
		<div class="form-group">
	        <button type="submit" class="btn btn-primary">提交</button>
	    </div>
		</form>
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
</script>
@endsection