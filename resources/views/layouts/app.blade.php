<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112168222-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-112168222-1');
    </script>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ola Stivos</title>

    <!-- GOOGLE ADS -->
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-2446013275029970",
        enable_page_level_ads: true
      });
    </script>

    <!-- Styles -->

    <!-- Bootstrap Styles -->
{{--         <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-h21C2fcDk/eFsW9sC9h0dhokq5pDinLNklTKoxIZRUn3+hvmgQSffLLQ4G4l2eEr" crossorigin="anonymous">

    <!-- Footer Styles -->
    <link rel="stylesheet" href="/css/footer/style.css">
    <link rel="stylesheet" href="/css/footer/footer-distributed.css">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

    <!-- Main CSS file  -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">



    @yield('styles')

</head>
<body>
    <div id="app">
        <!-- NAVBAR -->


        <!-- Banner with logo and navbar -->
        <div class="headers">
            <img class="img img-responsive" src="/img/banner_list.jpg">

            <div class="banner-content-left">
                <a href="/"><img src="/img/1logo.png" alt=""></a>
            </div>
            <div class="banner-content-center hidden-xs">
                <a href="#"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter-square fa-2x"></i></a>
                <a href="#"><i class="fa fa-linkedin-square fa-2x"></i></a>
                <a href="#"><i class="fa fa-youtube-square fa-2x"></i></a>
                                <div style="height:20vh;">
                </div>
{{--                 <ul>

                  <li>
                      Η μοναδική βάση δεδομένων για τον Κυπριακού στίβο
                  </li><li>
                      Καλύτερες επιδόσεις
                  </li><li>
                      Παγκύπρια Ρεκόρ
                  </li><li>
                      Προφίλ Κύπριων αθλητών
                  </li>
                </ul>  --}}
            </div>
        </div>
        <div id="startchange"></div>


        @include('partials.navbar' , ['nav_class' => 'navbar-static-top'])


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
