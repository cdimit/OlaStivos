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
    
    <!-- Bootstrap Styles -->
    {{--     <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-h21C2fcDk/eFsW9sC9h0dhokq5pDinLNklTKoxIZRUn3+hvmgQSffLLQ4G4l2eEr" crossorigin="anonymous">

    <!-- Footer Styles -->
    <link rel="stylesheet" href="/css/footer/style.css">
    <link rel="stylesheet" href="/css/footer/footer-distributed.css">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <!-- Other CSS -->
    <style type="text/css">
        /* Link CSS*/
/*
        a{
           color: #1A6B70;
        }
        a:hover {
            color: black;
        }*/
        .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
          background-image:none !important;
        }
        .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
            background-color: #15ACA0;
        }

    </style>

    @yield('styles')

</head>
<body>
    <div id="app">
        <!-- NAVBAR -->
        @include('partials.navbar' , ['nav_class' => 'navbar-fixed-top'])
        
        <!-- Banner with logo and navbar -->
        <div class="divWithBgImage">
            <div class="image" style="cursor: pointer;" onclick="window.location='/';">
                <a href="/home"></a>
      
            </div>
        </div>
        <div id="startchange"></div>
        

        @yield('content')

    </div>

    @include('partials.footer')

    <!-- Scripts -->
    <!-- Bootstrap Script -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    @yield('scripts')
    
    <!-- Search Panel Script -->
    <script type="text/javascript" src="/js/search/search_results_panel.js"></script>
    <!-- Navbar Animation Script -->
    <script src="{{ asset('js/navbar/navbar_animation.js') }}"></script>
</body>

</html>
