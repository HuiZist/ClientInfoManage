@extends('layouts.app')
@section('css')
<style type="text/css">
#digitNav>a{
	font-weight: bold;
	color:#000;
}
</style>
@endsection

@section('content')
<div id="statistics">
<div class="container">
	<div class="panel panel-default">
	  <div class="panel-heading">统计</div>
	  <div class="panel-body">
	    <!-- Table -->
	  	<table class="table">
	  	<thead>
	  		<tr>
	  			<th><i class="fa  fa-newspaper-o">&nbsp;&nbsp;</i>员工号</th>
	  			<th><i class="fa fa-user">&nbsp;&nbsp;</i>员工姓名</th>
	  			<th><i class="fa fa-star">&nbsp;&nbsp;</i>{{ $statTitle->s }}</th>
	  			<th><i class="fa fa-star">&nbsp;&nbsp;</i>{{ $statTitle->a }}</th>
	  			<th><i class="fa fa-star">&nbsp;&nbsp;</i>{{ $statTitle->b }}</th>
	  			<th><i class="fa fa-star">&nbsp;&nbsp;</i>{{ $statTitle->c }}</th>
	  		</tr>
	  	</thead>
	    <tbody>
	    @foreach($datas as $key=>$data)
	    	<tr>
	    		<td>{{ $data['operator_account'] }}</td>
	    		<td>{{ $data['operator_name'] }}</td>
	    		<td>
		    		<a href="/statistics/link/{{ $data['operator_account'] }}/{{ 's' }}">
		    			{{ $data['stat']['sDig'] }}
		    		</a>
	    		</td>
	    		<td>
	    			<a href="/statistics/link/{{ $data['operator_account'] }}/{{ 'a' }}">
	    				{{ $data['stat']['aDig'] }}
    				</a>
				</td>
	    		<td>
	    			<a href="/statistics/link/{{ $data['operator_account'] }}/{{ 'b' }}">
	    				{{ $data['stat']['bDig'] }}
	    			</a>
    			</td>
	    		<td>
	    			<a href="/statistics/link/{{ $data['operator_account'] }}/{{ 'c' }}">
	    				{{ $data['stat']['cDig'] }}
	    			</a>
    			</td>
	    	</tr>
	    @endforeach
	    </tbody>
	  	</table>
	  </div>
	</div>
	
</div>
	<div id="bottom" name="bottom"></div>
	<div class="appLocation btn-group-vertical" role="group">
		<a class="btn btn-default" href="#top"><i class="fa fa-chevron-up"></i></i></a>
		<a class="btn btn-default" href="#bottom"><i class="fa fa-chevron-down"></i></a>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection