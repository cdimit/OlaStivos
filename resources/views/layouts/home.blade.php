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
{{--     <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-h21C2fcDk/eFsW9sC9h0dhokq5pDinLNklTKoxIZRUn3+hvmgQSffLLQ4G4l2eEr" crossorigin="anonymous">

    <!-- Footer Styles -->
    <link rel="stylesheet" href="/css/footer/style.css">
    <link rel="stylesheet" href="/css/footer/footer-distributed.css">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">


    @yield('styles')
 
</head>
<body>
    <div id="app">
        @include('partials.navbar' , ['nav_class' => 'navbar-fixed-top'])
        <div class="divWithBgImage">
            <div class="image">

            </div>
        </div>
        @yield('content')

    </div>

    @include('partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    @yield('scripts_end')
</body>

</html>
