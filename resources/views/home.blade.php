@extends('layouts.app')

@section('styles')
{{--   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" /> --}}

  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

@endsection

@section('content')

<div class="container" style="background-color: #F9F9F9;">
  <div class="row" style="margin-top: 10px;">

    <!--************* -->
    <!-- Main Content -->
    <!--************* -->
    <!-- 2nd and 3rd columns -->
    <div class="col-lg-9 col-lg-push-3">
      <div class="row">

        <!--***********-->
        <!-- 2nd COLUMN-->
        <!--***********-->
        <div class="col-lg-8">
          @include('home.center-col')
        </div>


        <!-- *****************
        *** 3rd Column ******
        *****************-->
        <div class="col-lg-4 padding-3">
          @include('home.right-side-col')
        </div>

      </div>



    </div>

    <!--***********-->
    <!-- SIDE COLUMN-->
    <!--***********-->
    <div class="col-lg-3 col-lg-pull-9 padding-3">
      @include('home.left-side-col')
    </div>
  </div>
</div>
@endsection
