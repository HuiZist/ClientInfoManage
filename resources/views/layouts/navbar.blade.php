<nav class="navbar navbar-default navbar-static-top">
<div class="container">
    <div class="navbar-header">

        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', '用户信息管理') }}
        </a>
    </div>

    <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav" style="margin-left: 100px;">
            <li id="clientNav"><a href="{{ route('client.client') }}"><i class="fa fa-group">&nbsp;</i>客户总表</a></li>
            <li id="contractNav"><a href="{{ route('contract.show') }}"><i class="fa fa-phone">&nbsp;</i>联系表</a></li>
            <li id="knowledgeNav"><a href="{{ route('procedure.show') }}"><i class="fa fa-book">&nbsp;</i>知识库</a></li>
            <li id="digitNav"><a href="{{ route('statistics.show') }}"><i class="fa fa-pie-chart">&nbsp;</i>统计</a></li>
        </ul>
        <div id="top" name="top"></div>

        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li><a href="{{ route('login') }}">登录</a></li>
                <li><a href="{{ route('register') }}">注册</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa fa-user"></i>&nbsp;
                        {{ Auth::user()->name }} &nbsp;<span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                    @can('isSupAdmin')
                        <li><a href="{{ route('manage.memberShow') }}">成员管理</a></li>
                    @endcan
                    @can('isAdmin')
                        <li><a href="{{ route('contactType.show') }}">自定义</a></li>
                    @endcan
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                退出
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
</nav>