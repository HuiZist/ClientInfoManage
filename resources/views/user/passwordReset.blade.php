@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">重置密码</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('user.passwordResetting') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="account" value="{!! $user->account !!}">
                        <div class="form-group">
                        	<label for="account" class="col-md-4 control-label">账号</label>

                            <div class="col-md-6">
                                <input id="account" type="text" class="form-control" name="account" value="{!! $user->account !!}" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                        	<label for="question" class="col-md-4 control-label">密保问题</label>

                            <div class="col-md-6">
                                <input id="question" type="text" class="form-control" name="question" value="{!! $user->question !!}" disabled>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                            <label for="answer" class="col-md-4 control-label">密保回答</label>

                            <div class="col-md-6">
                                <input id="answer" type="text" class="form-control" name="answer" value="{{ old('answer') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">新密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" min="6" max="255" value="{{ old('password') }}"
                                placeholder="至少6位" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">确认密码</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" min="6" max="255" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    提交
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

@endsection