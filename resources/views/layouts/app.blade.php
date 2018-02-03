<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', '用户信息管理') }}</title>

<!-- Styles -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
<style type="text/css">

</style>
@yield('css')
</head>
<body>
<div id="app">
    @include('layouts.navbar')

    @yield('content')
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="/js/moment.js"></script>
<script src="/js/moment.zh-cn.js"></script>
<script src="/js/ion.calendar.min.js"></script>
<script src="/js/ion.calendar.min.js"></script>
<script src="/js/tipso.js"></script>
@include('UEditor::head')
@yield('js')
<script type="text/javascript">
$(function() {
    $('.tip').tipso({
        background:'#3097D1',
        position:'right',
    });
});
</script>
</body>
</html>
