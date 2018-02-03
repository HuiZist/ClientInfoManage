@extends('layouts.app')
@section('css')
<style type="text/css">

</style>
@endsection
@section('content')
<div id="memberShow">
<div class="container">
	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">成员管理</div>
	  <!-- Table -->
	  <table class="table table-striped table-hover">
	  	<thead><tr>
	  		<th>#ID</th>
	  		<th>姓名</th>
	  		<th>工号</th>
	  		<th>创建时间</th>
	  		<th>更改时间</th>
	  		<th>权限</th>
	  		<th>权限管理</th>
	  		<th>操作</th>
	  	</tr></thead>
	    <tbody>
	    	@foreach($users as $user)
	    	<tr>
	    	<td>{{ $user->id }}</td>
	    	<td>{{ $user->name }}</td>
	    	<td>{{ $user->account }}</td>
	    	<td>{{ $user->created_at }}</td>
	    	<td>{{ $user->updated_at }}</td>
	    	@if($user->is_admin===0)
	    	<td>普通成员</td>
	    	<td><a class="btn btn-default" href="/manage/admin/{{ $user->id }}">设为管理员</a></td>
	    	@elseif($user->is_admin===66)
	    	<td>管理员</td>
	    	<td><a class="btn btn-default" href="/manage/member/{{ $user->id }}">设为普通成员</a></td>
	    	@elseif($user->is_admin===67)
	    	<td>超级管理员</td>
	    	<td>无权限</td>
	    	@else
	    	<td>未知权限</td>
	    	<td><a class="btn btn-default" href="/manage/member/{{ $user->id }}">设为普通成员</a></td>
	    	@endif
		    <td>
			    @if($user->is_admin===67)
			    无权限
			    @else
			    <a class="btn btn-default" href="/manage/delete/{{ $user->id }}" onclick="return confirm('确定删除该账号？');">删除</a>
			    @endif
		    </td>
	    	</tr>
	    	@endforeach
	    </tbody>
	  </table>
	</div>
</div>
</div>

@endsection
@section('js')
@endsection