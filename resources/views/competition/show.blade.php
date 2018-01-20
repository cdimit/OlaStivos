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
                                        <p>
                                            <ul style="list-style: square;">
                                                
                                                @foreach($competition->competition_series as $series)
                                                    <li>
                                                        <h4>{{$series->name}}</h4>
                                                    </li>
                                                @endforeach
                                                
                                            </ul>
                                        </p>
                                        <p>
                                            <ul class="list-inline">
                                                <li class="list-inline-item seperator">{{date('d-M-Y', strtotime($competition->date_start))}} - {{date('d-M-Y', strtotime($competition->date_finish))}}
                                                </li>
                                                <li class="list-inline-item seperator">{{$competition->city}}</li>
                                                <li class="list-inline-item  seperator">{{$competition->country}}</li>
                                                <li class="list-inline-item">{{$competition->venue}}</li>
                                            </ul>
                                        </p>
                                        @foreach($competition->links as $link)
                                          <p><a href="{{$link->path}}" target="_blank">{{$link->name}}</a></p>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <p>
                                        <img src="{{ $competition->picture }}" class="img-responsive center" style="max-width: auto; max-height: auto;">
                                    </p>
                                </div>
                            </div>

                            <!-- RESULTS -->
                            @if($competition->results->count()>0)
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

                                                        <h4><b>{{$value->first()->event->name}}  -  {{date('d-m-Y', strtotime($value->first()->date))}}</b></h4>

                                                        @foreach($value->keyby('race')->keys() as $heat)
                                                            <h4>{{$heat}}</h4>
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
                                                                    @foreach($value->where('race',$heat) as $result)
                                                                        <tr>
                                                                            <td>{{$result->position}}</th>
                                                                            <td> <a href="/athlete/{{$result->athlete->id}}">{{$result->athlete->name}} </a></td>
                                                                            <th>{{$result->markstr}}</td>
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
                                                        @endforeach

                                                    </div>

                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          @endif
                        </div>

                        <!-- ****************************************** -->
                        <!--              PHOTOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab3default">
                            <h3>Φωτογραφίες Αγώνα</h3>
                            @if($competition->images->first())
                                @include('gallery.images', ['var' => $competition])
                            @endif

                        </div>


                        <!-- ****************************************** -->
                        <!--              VIDEOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab4default">
                            <h3>Βίντεο Αγώνα</h3>
                            @if($competition->videos->first())
                                @include('gallery.videos', ['var' => $competition])
                            @endif

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
