@extends('layouts.app')
@section('css')
<style type="text/css">

</style>
@endsection
@section('content')
<div id="conBEditor">
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">联系大类编辑</div>
		<div class="panel-body">
			<form method="POST" action="{{ route('contactBType.update') }}">
	           	{!! csrf_field() !!}
	           	<input type="hidden" name="b_id" value="{{ $conBType->id }}">
                <div class="form-group{{ $errors->has('btype') ? ' has-error' : '' }}">
                	<div class="input-group">
                		<span class="input-group-addon" id="basic-addon1">联系大类名</span>
                    	<input type="text" name="btype" class="form-control" 
                    	placeholder="必填，至多100字符" value="{{ $conBType->name }}" aria-describedby="basic-addon1">
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
                        <input type="number" name="ord" class="form-control" value={{ $conBType->ord }} aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                	<div class="input-group">
                		<span class="input-group-addon" id="basic-addon2">详情</span>
                    	<textarea name="detail" rows="5" class="form-control" placeholder="至多200字符" 
                    	aria-describedby="basic-addon2">{{ $conBType->detail }}</textarea>
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