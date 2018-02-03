<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>用户信息管理</title>

<!-- Fonts -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">

<!-- Styles -->
<style>
html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Raleway', sans-serif;
    font-weight: 100;
    height: 100vh;
    margin: 0;
    overflow: hidden;
}

.full-height {
    height: 100vh;
}

.flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
}

.position-ref {
    position: relative;
}

.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}

.content {
    text-align: center;
}

.title {
    font-size: 84px;
    font-family:Arial,Verdana,Sans-serif
}

.links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
}

.m-b-md {
    margin-bottom: 30px;
}
#appName{
    font-family: 'KaiTi';
}
#appName>p{
    font-size: 40px;
}
</style>
</head>
<body>
<div id="app">
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                <a href="{{ url('/client') }}">主页</a>
            @else
                <a href="{{ url('/login') }}">登录</a>
                <a href="{{ url('/register') }}">注册</a>
            @endif
        </div>
    @endif

    <div class="content">
        <div id="appName" class="title m-b-md">
            中信建投证券客户服务体系
            <p>Customer service system of CSC</p>
        </div>
    </div>
</div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript">
$(document).ready(function()
{
    $("#appName").addClass('animated bounceInLeft');
})
</script>
</body>
</html>
