@extends('layouts.app')
@section('css')
<style type="text/css">

</style>
@endsection
@section('content')
<div id="contactType">
<div class="container">
	<div class="proceSidebar btn-group-vertical" role="group">
    	<a class="contactLink btn" href="{{ route('contactType.show') }}"><i class="fa fa-credit-card">&nbsp;</i>联系类型</a>
    	<a class="statLink btn" href="{{ route('statdef.show') }}"><i class="fa fa-area-chart">&nbsp;</i>统计规则</a>
    	<a class="titleLink btn" href="{{ route('title.show') }}"><i class="fa fa-text-width">&nbsp;</i>表头名称</a>
    </div>
    <div class="panel panel-default">
	  <div class="panel-heading">自定义联系类型</div>
	  <div class="panel-body">
		<ul class="list-group">
		@foreach($btypes as $bk=>$btype)
		  <li class="list-group-item" title="{{ $btype->detail }}">
		  	<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapse{{ $bk }}" 
		  	aria-expanded="false" aria-controls="collapse{{ $bk }}">
			  {{ $btype->name }}&nbsp;&nbsp;<span style="font-size: 14px;">[{{ $btype->ord }}]</span>
			</a>
			<div class="collapse" id="collapse{{ $bk }}">
			  <div class="well">
				  <ul class="list-group">
				  	@foreach($btype->stype as $stype)
				  	<li class="list-group-item" title="{{ $stype->detail }}">
				  		{{ $stype->name }}&nbsp;&nbsp;<span style="font-size: 14px;">[{{ $stype->ord }}]</span>
					  	<span class="stypeDel">
					  		<a class="btn btn-sm btn-primary" href="/contactSType/editor/{{ $stype->id }}" title="编辑小类">
					  			<i class="fa fa-pencil"></i>
					  		</a>
					  		<a class="btn btn-sm btn-danger"  href="/contactSType/delete/{{ $stype->id }}" 
					  		onclick="return confirm('确定删除该小类？');"><i class="fa fa-trash-o"></i></a>
						</span>
					</li>
				  	@endforeach
				  </ul>
			    <button type="button" class="stypeAdd btn btn-primary" data-toggle="modal" data-target="#Modal{{ $bk }}">
				  增加小类
				</button>
				<a class="stypeAdd btn btn-info"  href="/contactBType/editor/{{ $btype->id }}">编辑大类</a>
				<a class="stypeAdd btn btn-danger"  href="/contactBType/delete/{{ $btype->id }}" 
				onclick="return confirm('确定删除该大类？');">删除大类</a>
				<!-- Modal -->
				<div class="modal fade" id="Modal{{ $bk }}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel{{ $bk }}">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="ModalLabel{{ $bk }}">增加联系类型小类</h4>
				      </div>
				      <form method="POST" action="{{ route('contactSType.add') }}">
				      	<div class="modal-body">
					        {!! csrf_field() !!}
					        <input type="hidden" name="b_id" value="{{ $btype->id }}">
					        <div class="form-group{{ $errors->has('stype') ? ' has-error' : '' }}">
			                	<div class="input-group">
			                		<span class="input-group-addon" id="basic-addon1">联系小类名</span>
			                    	<input type="text" name="stype" class="form-control" 
			                    	placeholder="必填，至多100字符" value="{{ old('stype') }}" aria-describedby="basic-addon1">
			                    </div>
			                    @if ($errors->has('stype'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('stype') }}</strong>
		                            </span>
		                        @endif
			                </div>
			                <div class="form-group">
			                	<div class="input-group">
			                		<span class="input-group-addon" id="basic-addon3">顺序编号</span>
			                    	<input type="number" name="ord" class="form-control" value=0 aria-describedby="basic-addon3">
			                    </div>
			                </div>
			                <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
			                	<div class="input-group">
			                		<span class="input-group-addon" id="basic-addon2">详情</span>
			                    	<input type="text" name="detail" class="form-control" 
			                    	placeholder="至多200字符" value="{{ old('detail') }}" aria-describedby="basic-addon2" height=100>
			                    </div>
			                    @if ($errors->has('detail'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('detail') }}</strong>
		                            </span>
		                        @endif
			                </div>
				      	</div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				        <button type="submit" class="btn btn-primary">提交</button>
				      </div>
				      </form>
				    </div>
				  </div>
				</div>
			  </div>
			</div>
		  </li>
		@endforeach
		</ul>

	    <button type="button" class="btypeAdd btn btn-primary" data-toggle="modal" data-target="#myModal">
		  增加联系类型大类
		</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">增加联系类型大类</h4>
		      </div>
		      <form method="POST" action="{{ route('contactBType.add') }}">
		      	<div class="modal-body">
			        {!! csrf_field() !!}
	                <div class="form-group{{ $errors->has('btype') ? ' has-error' : '' }}">
	                	<div class="input-group">
	                		<span class="input-group-addon" id="basic-addon1">联系大类名</span>
	                    	<input type="text" name="btype" class="form-control" 
	                    	placeholder="必填，至多100字符" value="{{ old('btype') }}" aria-describedby="basic-addon1">
	                    </div>
	                    @if ($errors->has('btype'))
                            <span class="help-block">
                                <strong>{{ $errors->first('btype') }}</strong>
                            </span>
                        @endif
	                </div>
	                <div class="form-group">
	                	<div class="input-group">
	                		<span class="input-group-addon" id="basic-addon3">顺序编号</span>
	                    	<input type="number" name="ord" class="form-control" value=0 aria-describedby="basic-addon3">
	                    </div>
	                </div>
	                <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
	                	<div class="input-group">
	                		<span class="input-group-addon" id="basic-addon2">详情</span>
	                    	<input type="text" name="detail" class="form-control" 
	                    	placeholder="至多200字符" value="{{ old('detail') }}" aria-describedby="basic-addon2" height=100>
	                    </div>
	                    @if ($errors->has('detail'))
                            <span class="help-block">
                                <strong>{{ $errors->first('detail') }}</strong>
                            </span>
                        @endif
	                </div>
		      	</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		        <button type="submit" class="btn btn-primary">提交</button>
		      </div>
		      </form>
		    </div>
		  </div>
		</div>
	    
	  </div>
	</div>
</div>
</div>
@endsection
@section('js')
@endsection