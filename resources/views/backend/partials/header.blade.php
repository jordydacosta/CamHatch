<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <span><img src="{{ URL::asset('img/logo.png') }}" width="15%"
                           class="pull-left brand"> CamHatch </span>@if(env('APP_ENV') == 'staging' || env('APP_ENV') == 'local') {!! '- <b>'.env('APP_ENV').'</b>' !!} @endif
            </a>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, {!! Auth::user()->name !!}!
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('profile') }}"><span class="icon-user"></span> Profile</a></li>
                        <li><a href="/auth/logout"><span class="icon-log-out"></span> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
