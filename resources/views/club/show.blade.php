@extends('layouts.app')
@section('styles')
   
    <link href="{{ asset('/css/profiles/profile.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/headings/heading-in-profile.css') }}" rel="stylesheet">

@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <!-- TABS List -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Πληροφορίες</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Φωτογραφίες</a></li>
                            <li><a href="#tab3default" data-toggle="tab">Βίντεο</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">

                        <!-- ****************************************** -->
                        <!--                MAIN TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade in active" id="tab1default">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="well">
                                        <p><h1>{{$club->name}}</h1></p>
                                        <p>
                                            <ul class="list-inline">
                                                <li class="list-inline-item seperator">{{$club->acronym}}</li>
                                                <li class="list-inline-item seperator">{{$club->since}}
                                                </li>
                                                <li class="list-inline-item">{{$club->city}}</li>
                                            </ul>
                                        </p>
                                    </div>    
                                </div>
                                <div class="col-sm-6">
                                    <p>
                                        <img src="/storage/{{ $club->picture }}" class="img-responsive center" style="max-width: auto; max-height: auto;">
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ****************************************** -->
                        <!--              PHOTOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab2default">
                
                            <h3>Φωτογραφίες Συλλόγου</h3>
                            @if($club->images->first())
                                @include('gallery.images', ['var' => $club])
                            @endif
                            
                        </div>


                        <!-- ****************************************** -->
                        <!--              VIDEOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab3default">
                            <h3>Βίντεο Συλλόγου</h3>
                            @if($club->videos->first())
                                @include('gallery.videos', ['var' => $club])
                            @endif
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection