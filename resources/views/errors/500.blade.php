@extends('layouts.app')
@section('css')
<style type="text/css">
.errorsBox{
	display: flex;
	justify-content: center;
	align-items: center;
	height:500px;
}
.errorsContent{
	text-align: center;
}
.errorsContent>p{
	line-height: 50px;
	font-size:30px;
	color: #000;
}
</style>
@endsection
@section('content')
<div class='container'>
	<div class="errorsBox">
		<div class="errorsContent">
			<h1>Http错误码：500</h1>
			<p>服务器发生错误</p>
			<p>{{ isset($message) ? $message : '' }}</p>
		</div>
	</div>
</div>
@endsection