@extends('layouts.app')
@section('styles')
   

<style>
    li.uppercase {
        text-transform: uppercase;
    }
    
    .list-inline{display:block;}
    
    .list-inline li{display:inline-block;}
    
    .list-inline li.seperator:after{content:'|'; margin:auto 20px;}

    /* Overrides list-group-item from Bootstrap */ 
    .list-group-item {
        padding: 3px 10px;
        font-size: 11px;
    }
    li.borderless {
        border-top: 0 none;
        border-right: 0 none;
        border-left: 0 none;
    }

    .table-condensed{
        font-size: 12px;
    }


    .list-group-item-achievement img{
        max-height: 20px;
        max-width: 20px;
        height: auto;
        width: auto;
        float: left;
        margin-left: -2px;
    }

    .panel.with-nav-tabs .panel-heading{
        padding: 5px 5px 0 5px;
    }
    .panel.with-nav-tabs .nav-tabs{
        border-bottom: none;
    }
    .panel.with-nav-tabs .nav-justified{
        margin-bottom: -1px;
    }

    h1{
        color: black;
        font-weight: bold; 
        text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;
    }

    .well {
       background-color: rgba(245, 245, 245, 0.4);
       margin-left: 1px;
       margin-right: 1px;
       margin-top: 1px;
       margin-bottom: 1px;
       border: 0;
    }




</style>
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