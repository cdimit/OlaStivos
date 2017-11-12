<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name','Ola Stivos') }}</title>

    <!-- Styles -->
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-h21C2fcDk/eFsW9sC9h0dhokq5pDinLNklTKoxIZRUn3+hvmgQSffLLQ4G4l2eEr" crossorigin="anonymous">
    @yield('styles')
    <style type="text/css">
        /* Link CSS*/

        a{
           color: #1A6B70;
        }
        a:hover {
            color: black;
        }
        .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
          background-image:none !important;
        }
        .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
            background-color: #15ACA0;
        }


    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0px; font-size: 12px; font-weight: bold;">
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
                        Όλα Στίβος
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Navbar Links -->
                        <li>
                            @include('search.search_input')
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Τοπ Λίστες<span class="caret"></span></a>
                            <ul class="dropdown-menu" style="color:white; background-color: black;">
                              <li><a href="{{route('alltime.show')}}" style="color:white;">Κορυφαίές Επιδόσεις</a></li>
                              <li><a href="{{route('toplist.show')}}" style="color:white;">Ανά Σεζόν</a></li>
                            </ul>
                        </li>

                        <li><a href="{{ route('record.showNRs') }}">Παγκύπρια Ρεκόρ</a></li>
                        <li><a href="{{ route('record.showNRsHistory') }}">Πρόοδος Παγκύπριων Ρεκόρ</a></li>
                        <li><a href="{{ route('competition.calendar') }}">Ημερολόγιο Αγώνων</a></li>
                        <li><a href="#">Επικοινωνία</a></li>

                    </ul>
                </div>
            </div>
        </nav>



        @yield('content')

    </div>

    @include('partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    @yield('scripts_end')

</body>

</html>
