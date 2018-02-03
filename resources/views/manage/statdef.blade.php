@extends('layouts.app')
@section('css')
<style type="text/css">

</style>
@endsection
@section('content')
<div id="statdef">
<div class="container">
	<div class="proceSidebar btn-group-vertical" role="group">
    	<a class="contactLink btn" href="{{ route('contactType.show') }}"><i class="fa fa-credit-card">&nbsp;</i>联系类型</a>
    	<a class="statLink btn" href="{{ route('statdef.show') }}"><i class="fa fa-area-chart">&nbsp;</i>统计规则</a>
    	<a class="titleLink btn" href="{{ route('title.show') }}"><i class="fa fa-text-width">&nbsp;</i>表头名称</a>
    </div>
    <form method="POST" action="{{ route('statdef.create') }}">
    {!! csrf_field() !!}
    <div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">自定义统计规则</div>
	  
	  <div class="panel-body">
	    <p>统计规则条件由星级依次递减，可自定义时间区间，无条件可设为0，不可为空</p>
	  </div>
	  <!-- Table -->
	  <table class="table">
	    <thead>
	    	<tr>
	    		<th>#数据项</th>
	    		<th>{{ $statTitle->s }}</th>
	    		<th>{{ $statTitle->a }}</th>
	    		<th>{{ $statTitle->b }}</th>
	    		<th>{{ $statTitle->c }}</th>
	    	</tr>
	    </thead>
	    <tbody>
		    <tr>
		    	<td>总记录量</td>
		    	<td><input type="number" class="form-control" name="scount" value="{{ $statdef->scount }}"></td>
		    	<td><input type="number" class="form-control" name="acount" value="{{ $statdef->acount }}"></td>
		    	<td><input type="number" class="form-control" name="bcount" value="{{ $statdef->bcount }}"></td>
		    	<td><input type="number" class="form-control" name="ccount" value="{{ $statdef->ccount }}"></td>
		    </tr>
		    <tr>
		    	<td>时间区间记录量</td>
		    	<td><input type="number" class="form-control" name="stcount" value="{{ $statdef->stcount }}"></td>
		    	<td><input type="number" class="form-control" name="atcount" value="{{ $statdef->atcount }}"></td>
		    	<td><input type="number" class="form-control" name="btcount" value="{{ $statdef->btcount }}"></td>
		    	<td><input type="number" class="form-control" name="ctcount" value="{{ $statdef->ctcount }}"></td>
		    </tr>
		    <tr>
		    	<td>时间区间</td>
		    	<td>
		    		<input type="text" name="btime" class="date form-control" placeholder="请选择日期" value="{{ $statdef->btime }}" title="起始时间">
		    	</td>
		    	<td>
		    		<input type="text" name="etime" class="date form-control" placeholder="请选择日期" value="{{ $statdef->etime }}" title="结束时间">
		    	</td>
		    </tr>
	    </tbody>
	  </table>
	  <div>
	  	<button type="submit" class="btn btn-primary statdefSub">提交</button>
	  </div>
	</div>
	</form>

	<form method="POST" action="{{ route('statdef.titleUpdate') }}">
	{!! csrf_field() !!}
	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">统计规则标题</div>
	  <div class="panel-body">
	  <table class="table">
	  	<thead>
	  		<tr>
	  			<th>S</th>
	  			<th>A</th>
	  			<th>B</th>
	  			<th>C</th>
	  		</tr>
	  	</thead>
	  	<tbody>
		  	<tr>
		  		<td>
		  			<input class="form-control" type="text" name="S" value="{{ $statTitle->s }}">
		  		</td>
		  		<td>
		  			<input class="form-control" type="text" name="A" value="{{ $statTitle->a }}">
		  		</td>
		  		<td>
		  			<input class="form-control" type="text" name="B" value="{{ $statTitle->b }}">
		  		</td>
		  		<td>
		  			<input class="form-control" type="text" name="C" value="{{ $statTitle->c }}">
		  		</td>
		  	</tr>
	  	</tbody>
	  </table>
	  <div>
	  	<button type="submit" class="btn btn-primary statdefSub">提交</button>
	  </div>
	  </div>
    </div>
    </form>
</div>
</div>
@endsection
@section('js')
<script src="js/moment.js"></script>
<script src="js/moment.zh-cn.js"></script>
<script src="js/ion.calendar.min.js"></script>
<script type="text/javascript">
$(function(){
    $('.date').each(function(){
        $(this).ionDatePicker({
            lang: 'zh-cn',
            format: 'YYYY-MM-DD'
        });
    });
});
</script>
@endsection