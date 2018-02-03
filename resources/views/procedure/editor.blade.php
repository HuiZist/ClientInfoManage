@extends('layouts.app')
@section('css')
<style type="text/css">

</style>
@endsection
@section('content')
<div id="proceEditor">
<div class="container">
<div class="panel panel-primary">
  <div class="panel-heading">业务编辑</div>
  <div class="panel-body">
    <form method="POST" action="{{ route('procedure.editor') }}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="proceId" value="{{ $proceId }}">
    <input type="hidden" name="post_time" value="{{ $procedure->post_time }}">
    <div class="form-group{{ $errors->has('btype') ? ' has-error' : '' }}">
    	<label for="btype">业务大类</label>
        <input type="text" class="form-control" name="btype" id="btype" 
        placeholder="至少3个字符，至多200个字符" value="{{ $procedure->btype }}">
        @if ($errors->has('btype'))
            <span class="help-block">
                <strong>{{ $errors->first('btype') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('stype') ? ' has-error' : '' }}">
    	<label for="stype">业务小类</label>
        <input type="text" class="form-control" name="stype" id="stype" 
        placeholder="至少3个字符，至多200个字符" value="{{ $procedure->stype }}">
        @if ($errors->has('stype'))
            <span class="help-block">
                <strong>{{ $errors->first('stype') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
    <label>详细描述</label>
    <script id="container" name="content" type="text/plain" style="height:300px;">
            {!! $procedure->content !!}
    </script>
    @if ($errors->has('content'))
        <span class="help-block">
            <strong>{{ $errors->first('content') }}</strong>
        </span>
    @endif
    </div>

	<div class="modal-footer">
	    <button type="submit" class="btn btn-primary">发布</button>
	</div>

	</form>
  </div>
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