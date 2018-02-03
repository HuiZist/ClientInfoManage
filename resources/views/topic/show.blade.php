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
<div id="topic">
<div class="container">
	<div class="proceSidebar btn-group-vertical" role="group">
    	<a class="proceLink btn" href="{{ route('procedure.show') }}"><i class="fa fa-line-chart">&nbsp;</i>业务</a>
    	<a class="topicLink btn" href="{{ route('topic.show') }}"><i class="fa fa-laptop">&nbsp;</i>话术</a>
    </div>
    <div class="btn-group btn-group proceExcelImport" role="group">
    	@can("isAdmin")
	  	<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
		  <i class="fa fa-sign-in"></i>&nbsp;&nbsp;话术表导入
		</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">请从本地选择Excel文件导入</h4>
		      </div>
		      <form method="POST" action="{{ route('topic.upload') }}" enctype="multipart/form-data">
	           	<div class="modal-body">
	                {!! csrf_field() !!}
	                <div class="form-group">
	                    <input type="file" name="topicExcel" id="topicExcel">
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
		<form class="form-inline" action="{{ route('topic.search') }}" method="GET" >
			{!! csrf_field() !!}
			<div class="form-group">
				<input type="text" name="product_type" class="form-control" placeholder="产品类型">
			    <input type="text" name="topic_type" class="form-control" placeholder="话术类型">
			    <input type="text" name="source" class="form-control" placeholder="话术来源">
			    <input type="text" name="content" class="form-control" placeholder="话术详情">
		    <button type="submit" class="btn btn-primary"><i class="fa fa-search">&nbsp;</i>查询</button>
	    	</div>
		</form>
		<!-- Button trigger modal -->
			<button type="button" id="proCreate" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">
			  <i class="fa fa-edit"></i>&nbsp;&nbsp;话术发布
			</button>
			<!-- Modal -->
			<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        发布业务
			      </div>
			      <form method="POST" action="{{ route('topic.create') }}" enctype="multipart/form-data">
                   	<div class="modal-body">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('product_type') ? ' has-error' : '' }}">
                        	<label for="product_type">产品类型</label>
                            <input type="text" class="form-control" name="product_type" id="product_type" 
                            placeholder="必填，至多200个字符" value="{{ old('product_type') }}">
                            @if ($errors->has('product_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('topic_type') ? ' has-error' : '' }}">
                        	<label for="topic_type">话术类型</label>
                            <input type="text" class="form-control" name="topic_type" id="topic_type" 
                            placeholder="必填，至多200个字符" value="{{ old('topic_type') }}">
                            @if ($errors->has('topic_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('topic_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('source') ? ' has-error' : '' }}">
                        	<label for="source">话术来源</label>
                            <input type="text" class="form-control" name="source" id="source" 
                            placeholder="必填，至多200个字符" value="{{ old('source') }}">
                            @if ($errors->has('source'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('source') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                        <label>话术详情</label>
                        <script id="container" name="content" type="text/plain" style="height:300px;">
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

	<div class="topicList">
		<div class="topicTitle">
			<span class="topicProduct"><i class="fa fa-tags">&nbsp;&nbsp;</i>产品类型</span>
            <span class="topicType"><i class="fa fa-tag">&nbsp;&nbsp;</i>话术类型</span>
            <span class="topicSource"><i class="fa fa-briefcase">&nbsp;&nbsp;</i>话术来源</span>
            <span class="topicUtime"><i class="fa fa-refresh">&nbsp;&nbsp;</i>更新时间</span>
            <span class="topicCtime"><i class="fa fa-clock-o">&nbsp;&nbsp;</i>添加时间</span>
            <span class="topicPname"><i class="fa fa-user">&nbsp;&nbsp;</i>话术作者</span>
		</div>
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		@foreach($topics as $key=>$topic)
			<div class="panel topicPanel">
			    <div class="panel-heading" role="tab" id="heading{{ $topic->id }}">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" 
			        href="#collapse{{ $topic->id }}" aria-expanded="false" aria-controls="collapse{{ $topic->id }}">
			          <span class="topicProduct" title="{{ $topic->product_type }}">{{ $topic->product_type }}</span>
			          <span class="topicType" title="{{ $topic->topic_type }}">{{ $topic->topic_type }}</span>
			          <span class="topicSource" title="{{ $topic->source }}">{{ $topic->source }}</span>
			          <span class="topicUtime" title="{{ $topic->updated_at }}">{{ $topic->updated_at }}</span>
			          <span class="topicCtime" title="{{ $topic->created_at }}">{{ $topic->created_at }}</span>
			          <span class="topicPname" title="{{ $topic->post_name }}">{{ $topic->post_name }}</span>
			        </a>
			      </h4>
			    </div>
			    <div id="collapse{{ $topic->id }}" class="panel-collapse collapse" role="tabpanel" 
			    aria-labelledby="heading{{ $topic->id }}">
			      <div class="panel-body">
			        {!! $topic->content !!}
			        <div class="topicBtn">
			        @can('canEditorAccount',$topic->post_account)
				        <a class="btn btn-danger btn-sm" href="/topic/destory/{{ $topic->id }}" onclick="return confirm('确定删除该业务？');">删除</a>
				        <a class="btn btn-primary btn-sm" href="/topic/editor/{{ $topic->id }}">编辑</a>
				    @endcan
			        </div>
			      </div>
			    </div>
			</div>
		@endforeach
		</div>
	</div>
	<div class="page">
	@if(isset($request))
	    {!! $topics->appends(['product_type'=>$request->product_type,
	    	'topic_type'=>$request->topic_type,
	    	'source'=>$request->source,
	    	'content'=>$request->content,
	    	])->render() !!}
	@else
		{{ $topics->links() }}
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