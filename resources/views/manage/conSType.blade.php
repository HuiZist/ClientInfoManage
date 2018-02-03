@extends('layouts.app')
@section('css')
<style type="text/css">

</style>
@endsection
@section('content')
<div id="conSEditor">
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">联系小类编辑</div>
		<div class="panel-body">
			<form method="POST" action="{{ route('contactSType.update') }}">
	           	{!! csrf_field() !!}
	           	<input type="hidden" name="s_id" value="{{ $conSType->id }}">
                <div class="form-group{{ $errors->has('stype') ? ' has-error' : '' }}">
                	<div class="input-group">
                		<span class="input-group-addon" id="basic-addon1">联系小类名</span>
                    	<input type="text" name="stype" class="form-control" 
                    	placeholder="必填，至多100字符" value="{{ $conSType->name }}" aria-describedby="basic-addon1">
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
                        <input type="number" name="ord" class="form-control" value={{ $conSType->ord }} aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                	<div class="input-group">
                		<span class="input-group-addon" id="basic-addon2">详情</span>
                    	<textarea name="detail" rows="5" class="form-control" placeholder="至多200字符" 
                    	aria-describedby="basic-addon2">{{ $conSType->detail }}</textarea>
                    </div>
                    @if ($errors->has('detail'))
                        <span class="help-block">
                            <strong>{{ $errors->first('detail') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                	<button type="submit" class="btn btn-primary">提交</button>
                </div>
            </form>
		</div>
	</div>
</div>
</div>
@endsection
@section('js')
@endsection