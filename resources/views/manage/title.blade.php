@extends('layouts.app')
@section('css')
<style type="text/css">

</style>
@endsection
@section('content')
<div id="titleShow">
<div class="container">
	<div class="proceSidebar btn-group-vertical" role="group">
    	<a class="contactLink btn" href="{{ route('contactType.show') }}"><i class="fa fa-credit-card">&nbsp;</i>联系类型</a>
    	<a class="statLink btn" href="{{ route('statdef.show') }}"><i class="fa fa-area-chart">&nbsp;</i>统计规则</a>
    	<a class="titleLink btn" href="{{ route('title.show') }}"><i class="fa fa-text-width">&nbsp;</i>表头名称</a>
    </div>
    <div class="panel panel-default">
   	<div class="panel-heading">客户总表表头</div>
	  <div class="panel-body">
		<form method="POST" class="form-inline" action="{{ route('title.cliUpdate') }}">
		{!! csrf_field() !!}
			<div class="form-group">
			@foreach($clients as $ck=>$client)
			@if($ck !== 'id' && $ck !== 'created_at' && $ck !== 'updated_at')
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon{{ $ck }}">{{ $ck }}</span>
				<input type="text" name="{{ $ck }}" class="date form-control" aria-describedby="basic-addon{{ $ck }}"
	  			value="{{ $client }}">
			</div>
			@endif
			@endforeach
			</div>
			<div class="form-group" style="float:right;">
		    	<button type="submit" class="btn btn-primary">修改</button>
		    </div>
		</form>
	  </div>
	</div>

	<div class="panel panel-default">
   	<div class="panel-heading">联系表表头</div>
	  <div class="panel-body">
		<form method="POST" class="form-inline" action="{{ route('title.conUpdate') }}">
		{!! csrf_field() !!}
			<div class="form-group">
			@foreach($contacts as $ak=>$contact)
				@if($ak==='I')
					@break
				@endif
			@if($ak !== 'id' && $ak !== 'created_at' && $ak !== 'updated_at')
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon{{ $ak }}">{{ $ak }}</span>
				<input type="text" name="{{ $ak }}" class="date form-control" aria-describedby="basic-addon{{ $ak }}"
	  			value="{{ $contact }}">
			</div>
			@endif
			@endforeach
			</div>
			<div class="form-group" style="float:right;">
		    	<button type="submit" class="btn btn-primary">修改</button>
		    </div>
		</form>
	  </div>
	</div>
</div>
</div>
@endsection
@section('js')
@endsection