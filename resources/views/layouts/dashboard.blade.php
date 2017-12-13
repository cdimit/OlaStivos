<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

    <style type="text/css">
        .red-square {
            float:right;
            width: 20px;
            height: 20px;
            background: #ffd6cc;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div id="app">
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
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="list-group">
                        <a href="{{ route('club.index') }}" class="list-group-item">
                        Clubs</a>
                        <a href="{{ route('athlete.index') }}" class="list-group-item list-group-item-action">Athletes</a>
                        <a href="{{ route('series.index') }}" class="list-group-item list-group-item-action">Series</a>
                        <a href="{{ route('competition.index') }}" class="list-group-item list-group-item-action">Competitions</a>
                        <a href="{{ route('result.index') }}" class="list-group-item list-group-item-action">Results</a>
                        <a href="{{ route('image.index') }}" class="list-group-item list-group-item-action">Images</a>
                        <a href="{{ route('video.index') }}" class="list-group-item list-group-item-action">Videos</a>
                        @if(Auth::user() && Auth::user()->isAdmin())
                            <a href="{{ route('pending.index') }}" class="list-group-item list-group-item-action">Pending</a>
                            <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">Users</a>
                        @endif
                    </div>

                </div>
                <div class="col-sm-8">
                    @yield('content')
                </div>
                <div class="col-sm-2">
                    @yield('right_col')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
