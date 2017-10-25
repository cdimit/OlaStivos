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
        <div class="col-md-8 col-md-offset-2">
            <div class="panel with-nav-tabs panel-default" style="margin-top: 51px;">
                <div class="panel-heading">
                        <!-- TABS List -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Πληροφορίες & Αποτελέσματα</a></li>
                            <li><a href="#tab3default" data-toggle="tab">Φωτογραφίες</a></li>
                            <li><a href="#tab4default" data-toggle="tab">Βίντεο</a></li>
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
                                        <p><h1>{{$competition->name}}</h1></p>
                                        <p><h3>{{$competition->series->name}}</h3></p>
                                        <p>
                                            <ul class="list-inline">
                                                <li class="list-inline-item seperator">{{date('d-m-Y', strtotime($competition->date_start))}} - {{date('d-m-Y', strtotime($competition->date_finish))}}
                                                </li>
                                                <li class="list-inline-item seperator">{{$competition->city}}</li>
                                                <li class="list-inline-item  seperator">{{$competition->country}}</li>
                                                <li class="list-inline-item">{{$competition->venue}}</li>
                                            </ul>
                                        </p>
                                    </div>    
                                </div>
                            </div>

                            <!-- RESULTS -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel with-nav-tabs panel-default">
                                        <div class="panel-heading">
                                            <h2>Αποτελέσματα:</h2>
                                            <!-- Results TABS List -->
                                            <ul class="nav nav-tabs">
                                              <li class="dropdown">
                                                <a href="#" data-toggle="dropdown">Αγώνισμα<span class="caret"></span></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    @foreach($results as $key => $value)
                                                        @if ($value->first()->event->gender == 'male')
                                                            <li><a href="#tab{{$key}}result" data-toggle="tab">ΑΝΔΡEΣ {{$value->first()->event->name}}</a></li>
                                                        @else         
                                                            <li><a href="#tab{{$key}}result" data-toggle="tab">ΓΥΝΑΙΚEΣ {{$value->first()->event->name}}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                              </li>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                @foreach($results as $key => $value)
                                                    <div class="tab-pane fade" id="tab{{$key}}result">
                                                        
                                                            <h4>{{$value->first()->event->name}}  -  {{date('d-m-Y', strtotime($value->first()->date))}}</h4>
                                                            
                                                                <table class="table table-condensed table-responsive">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Θέση</th>
                                                                            <th>Aθλητής</th>
                                                                            <th>Επίδοση</th>
                                                                            <th>Πόντοι</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="myTable">                                 
                                                                        @foreach($value as $result)
                                                                            <tr>
                                                                                <td>{{$result->position}}</th>
                                                                                <td>{{$result->athlete->first_name}} {{$result->athlete->last_name}}</td>
                                                                                <th>{{$result->mark}}</td>
                                                                                <td>{{$result->score}}</td>
                                                                                <td>
                                                                                @foreach($result->records as $record)
                                                                                    {{$record->acronym}} &nbsp;
                                                                                @endforeach
                                                                                </td>
                                                                            </tr>

                                                                        @endforeach
                                                                    </tbody>

                                                                </table>

                                                    
                                                        
                                                    </div>
                                                
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ****************************************** -->
                        <!--              PHOTOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab3default">
                
                                Photos of competition
                  
                            
                        </div>


                        <!-- ****************************************** -->
                        <!--              VIDEOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab4default">
                            Videos of competition
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection