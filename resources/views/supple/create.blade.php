@extends('layouts.app')
@section('css')
<style type="text/css">

</style>
@endsection
@section('content')
<div id="proceSupple">
<div class="container">
<div class="panel panel-info">
  <div class="panel-heading">业务补充</div>
  <div class="panel-body">
      <div class="form-group">
          <label>业务大类：&nbsp;&nbsp;</label>
          {{ $procedure->btype }}
      </div>
      <div class="form-group">
          <label>业务小类：&nbsp;&nbsp;</label>
          {{ $procedure->stype }}
      </div>
      <div class="form-group">
          <label>详细描述：&nbsp;&nbsp;</label>
          {!! $procedure->content !!}
      </div>
  </div>
  <div class="panel-body">
    <form method="POST" action="{{ route('supple.create') }}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="proceId" value="{{ $proceId }}">
    
    <div class="form-group">
        <label>补充内容</label>
        <script id="container" name="content" type="text/plain" style="height:500px;">
        </script>
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