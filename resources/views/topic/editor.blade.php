@extends('layouts.app')
@section('css')
<style type="text/css">

</style>
@endsection
@section('content')
<div id="topicEditor">
<div class="container">
<div class="panel panel-primary">
  <div class="panel-heading">话术编辑</div>
  <div class="panel-body">
    <form method="POST" action="{{ route('topic.editor') }}" enctype="multipart/form-data">
    <div class="modal-body">
        {!! csrf_field() !!}
        <input type="hidden" name="topicId" value="{{ $topicId }}">
        <div class="form-group{{ $errors->has('product_type') ? ' has-error' : '' }}">
            <label for="product_type">产品类型</label>
            <input type="text" class="form-control" name="product_type" id="product_type" 
            placeholder="必填，至多200个字符" value="{{ $topic->product_type }}">
            @if ($errors->has('product_type'))
                <span class="help-block">
                    <strong>{{ $errors->first('product_type') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('topic_type') ? ' has-error' : '' }}">
            <label for="topic_type">话术类型</label>
            <input type="text" class="form-control" name="topic_type" id="topic_type" 
            placeholder="必填，至多200个字符" value="{{ $topic->topic_type }}">
            @if ($errors->has('topic_type'))
                <span class="help-block">
                    <strong>{{ $errors->first('topic_type') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('source') ? ' has-error' : '' }}">
            <label for="source">话术来源</label>
            <input type="text" class="form-control" name="source" id="source" 
            placeholder="必填，至多200个字符" value="{{ $topic->source }}">
            @if ($errors->has('source'))
                <span class="help-block">
                    <strong>{{ $errors->first('source') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
        <label>话术详情</label>
        <script id="container" name="content" type="text/plain" style="height:300px;">
            {!! $topic->content !!}
        </script>
        @if ($errors->has('content'))
            <span class="help-block">
                <strong>{{ $errors->first('content') }}</strong>
            </span>
        @endif
        </div>
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