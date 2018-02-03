@extends('layouts.app')
@section('css')
<style type="text/css">
#knowledgeNav>a{
	font-weight: bold;
	color:#000;
}
</style>
@endsection
@section('content')
<div id="procedure">
<div class="container">
	<div class="proceSidebar btn-group-vertical" role="group">
    	<a class="proceLink btn" href="{{ route('procedure.show') }}"><i class="fa fa-line-chart">&nbsp;</i>业务</a>
    	<a class="topicLink btn" href="{{ route('topic.show') }}"><i class="fa fa-laptop">&nbsp;</i>话术</a>
    </div>
    <div class="btn-group btn-group proceExcelImport" role="group">
    	@can("isAdmin")
	  	<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
		  <i class="fa fa-sign-in"></i>&nbsp;&nbsp;业务表导入
		</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">请从本地选择Excel文件导入</h4>
		      </div>
		      <form method="POST" action="{{ route('procedure.upload') }}" enctype="multipart/form-data">
	           	<div class="modal-body">
	                {!! csrf_field() !!}
	                <div class="form-group">
	                    <input type="file" name="procedureExcel" id="procedureExcel">
	                </div>
	                <p class="remind"><i class="fa fa-exclamation-circle">&nbsp;</i>请确认Excel文件中只有一个sheet，数据行不超过1W，且表头正确！</p>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
	                <button type="submit" class="btn btn-primary">导入</button>
	            </div>
	           </form>
		    </div>
		  </div>
		</div>
		@endcan
		<form class="form-inline" action="{{ route('procedure.search') }}" method="GET">
			{!! csrf_field() !!}
			<div class="form-group">
			    <input type="text" name="btype" class="form-control" placeholder="业务大类">
			    <input type="text" name="stype" class="form-control" placeholder="业务小类">
			    <input type="text" name="content" class="form-control" placeholder="详细内容">
			    <input type="text" name="post_name" class="form-control" placeholder="添加人员">
		    <button type="submit" class="btn btn-primary"><i class="fa fa-search">&nbsp;</i>查询</button>
	    </div>
		</form>
		<!-- Button trigger modal -->
			<button type="button" id="proCreate" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">
			  <i class="fa fa-edit"></i>&nbsp;&nbsp;业务发布
			</button>
			<!-- Modal -->
			<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        发布业务
			      </div>
			      <form method="POST" action="{{ route('procedure.create') }}" enctype="multipart/form-data">
                   	<div class="modal-body">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('btype') ? ' has-error' : '' }}">
                        	<label for="btype">业务大类</label>
                            <input type="text" class="form-control" name="btype" id="btype" 
                            placeholder="至少3个字符，至多200个字符" value="{{ old('btype') }}">
                            @if ($errors->has('btype'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('btype') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('stype') ? ' has-error' : '' }}">
                        	<label for="stype">业务小类</label>
                            <input type="text" class="form-control" name="stype" id="stype" 
                            placeholder="至少3个字符，至多200个字符" value="{{ old('stype') }}">
                            @if ($errors->has('stype'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('stype') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                        <label>详细描述</label>
                        <script id="container" name="content" type="text/plain" style="height:400px;">
                        	{!! old('content') !!}
                        </script>
                        @if ($errors->has('content'))
                            <span class="help-block">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">发布</button>
                    </div>
                   </form>
			    </div>
			  </div>
			</div>
	</div>
	<div class="proceList">
		<div class="proceTitle">
			<span class="proceBType"><i class="fa fa-tags">&nbsp;&nbsp;</i>业务大类</span>
		    <span class="proceSType"><i class="fa fa-tag">&nbsp;&nbsp;</i>业务小类</span>
		    <span class="proceUtime"><i class="fa fa-refresh">&nbsp;&nbsp;</i>更新时间</span>
		    <span class="proceCtime"><i class="fa fa-clock-o">&nbsp;&nbsp;</i>添加时间</span>
		    <span class="proceName"><i class="fa fa-user">&nbsp;&nbsp;</i>添加人员</span>
		</div>
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		@foreach($proces as $key=>$proce)
			<div class="panel procePanel">
			    <div class="panel-heading" role="tab" id="heading{{ $proce->id }}">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" 
			        href="#collapse{{ $proce->id }}" aria-expanded="false" aria-controls="collapse{{ $proce->id }}">
			          <span class="proceBType" title="{{ $proce->btype }}">{{ $proce->btype }}</span>
			          <span class="proceSType" title="{{ $proce->stype }}">{{ $proce->stype }}</span>
			          <span class="proceUtime" title="{{ $proce->updated_at }}">{{ $proce->updated_at }}</span>
			          <span class="proceCtime" title="{{ $proce->post_time }}">{{ $proce->post_time }}</span>
			          <span class="proceName" title="{{ $proce->post_name }}">{{ $proce->post_name }}</span>
			        </a>
			      </h4>
			    </div>
			    <div id="collapse{{ $proce->id }}" class="panel-collapse collapse" role="tabpanel" 
			    aria-labelledby="heading{{ $proce->id }}">
			      <div class="panel-body">
			        {!! $proce->content !!}
			        <ul class="list-group">
				        @foreach($proce->supples as $sk=>$sv)
				        <li class="list-group-item">
				        	<div>{!! $sv->content !!}</div>
					        <div class="proSuper">
					        	<span title="补充员工姓名"><i class="fa fa-user">&nbsp;&nbsp;&nbsp;&nbsp;</i>{{$sv->post_name}}</span>
					        	<span title="员工号"><i class="fa fa-info">&nbsp;&nbsp;&nbsp;&nbsp;</i>{{$sv->post_account}}</span>
				        		<span title="补充时间"><i class="fa fa-clock-o">&nbsp;&nbsp;&nbsp;&nbsp;</i>{{$sv->created_at}}</span>
				        		@can('canEditorAccount',$sv->post_account)
					        		<a class="btn btn-danger btn-xs" href="/procedure/supple/destroy/{{ $sv->id }}" 
					        		onclick="return confirm('确定删除该补充？');"><i class="fa fa-trash-o"></i></a>
				        		@endcan
					        </div>
				        </li>
				        @endforeach
			        </ul>
			        <div class="proceBtn">
			        	@can('canEditorAccount',$proce->post_account)
				        	<a class="btn btn-danger btn-sm" href="/procedure/destory/{{ $proce->id }}" 
				        		onclick="return confirm('确定删除该业务？');">删除</a>
				        	<a class="btn btn-primary btn-sm" href="/procedure/editor/{{ $proce->id }}">编辑</a>
				        @endcan
				        <a class="btn btn-info btn-sm" href="/procedure/supple/{{ $proce->id }}">补充</a>
			        </div>
			      </div>
			    </div>
			</div>
		@endforeach
		</div>
	</div>

	<div class="page">
	@if(isset($request))
	    {!! $proces->appends(['post_name'=>$request->post_name,
	    	'btype'=>$request->btype,
	    	'stype'=>$request->stype,
	    	'content'=>$request->content,
	    	])->render() !!}
	@else
		{{ $proces->links() }}
	@endif
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
var ue = UE.getEditor('container',{
        toolbars: [[
            'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 
            'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|', 'imagenone', 'imageleft', 
            'imageright', 'imagecenter', '|',
            'insertimage', 'emotion', 'scrawl', 'attachment', 'map', 'background', '|',
            'horizontal', 'date', 'time', 'spechars', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 
            'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
            'print', 'preview', 'searchreplace', 'help'
        ]]});

</script>
@endsection