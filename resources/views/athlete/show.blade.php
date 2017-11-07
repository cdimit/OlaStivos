@extends('layouts.app')
@section('styles')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>


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
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <!-- TABS List -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Πληροφορίες</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Αποτελέσματα</a></li>
                            <li><a href="#tab3default" data-toggle="tab">Φωτογραφίες</a></li>
                            <li><a href="#tab4default" data-toggle="tab">Βίντεο</a></li>
                            <li><a href="#tab5default" data-toggle="tab">Σύνδεσμοι</a></li>
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
                                    <p><h1>{{$athlete->first_name}} {{$athlete->last_name}}</h1></p>
                                    <p>
                                        <ul class="list-inline">
                                            @if ( $athlete->gender == 'male')
                                                <li class="list-inline-item seperator">ΑΝΔΡΑΣ</li>
                                            @else
                                                <li class="list-inline-item seperator  uppercase">ΓΥΝΑΙΚΑ</li>
                                            @endif
                                            <li class="list-inline-item seperator">{{$athlete->dob}}</li>
                                            <li class="list-inline-item">{{$athlete->club->acronym}}</li>
                                        </ul>
                                    </p>
                                    <p>
                                        <!--      Achievements      -->
                                        <ul class="list-group">
                                            <li class="list-group-item borderless" style="font-size:12px "><b>Επιτεύγματα:</b></li>
                                            @foreach($NRs as $NR)
                                                <li class="list-group-item icon icon-bullet">
                                                    <span class="list-group-item-achievement">
                                                        <img src="https://cdn3.iconfinder.com/data/icons/glypho-generic-icons/64/prize-badge-512.png" class="img-responsive center">
                                                    </span>
                                                    Παγκύπριο ρεκόρ: <i>{{$NR->event->name}} &ensp;  <b>{{$NR->mark}}</b></i>
                                                </li>
                                            @endforeach
                                            @foreach($NURs as $NUR)
                                                <li class="list-group-item">
                                                    Παγκύπριο ρεκόρ U23: <i>{{$NUR->event->name}} &ensp; <b>{{$NUR->mark}}</b></i>
                                                </li>
                                            @endforeach
                                            @foreach($NJRs as $NJR)
                                                <li class="list-group-item">Παγκύπριο ρεκόρ U19:<i> {{$NJR->event->name}} &ensp;<b>{{$NJR->mark}}</b></i></li>
                                            @endforeach
                                            @foreach($NYRs as $NYR)
                                                <li class="list-group-item">Παγκύπριο ρεκόρ U17:<i> {{$NYR->event->name}} &ensp; <b>{{$NYR->mark}}</b></i></li>
                                            @endforeach

                                            <li class="list-group-item">Παγκύπριες νίκες: &ensp; <i><b>{{$nwins}}</b></i></li>
                                        </ul>
                                    </p>
                                </div>
                                </div>
                                <div class="col-sm-6">
                                    <p>
                                        <img src="/storage/{{ $athlete->picture }}" class="img-responsive center" style="max-width: auto; max-height: auto;">
                                    </p>
                                </div>
                            </div>

                            <div class="row" style="margin-top:10px">
                                <div class="col-sm-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Καλύτερες Επιδόσεις Σεζόν - SB</div>
                                        <div class="panel-body">
                                            <table class="table table-condensed table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Αγώνισμα</th>
                                                        <th>Αγώνας</th>
                                                        <th>Επίδοση</th>
                                                        <th>Πόντοι</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sbs as $sb)
                                                        <tr>
                                                            <th scope="row">{{$sb->event->name}}</th>
                                                            <td>{{$sb->competition->name}}</td>
                                                            <td>{{$sb->mark}}</td>
                                                            <td>{{$sb->score}}</td>

                                                        </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Ατομικά Ρεκόρ - PB</div>
                                        <div class="panel-body">
                                            <table class="table table-condensed table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Αγώνισμα</th>
                                                        <th>Αγώνας</th>
                                                        <th>Επίδοση</th>
                                                        <th>Πόντοι</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pbs as $pb)
                                                        <tr>
                                                            <th scope="row">{{$pb->event->name}}</th>
                                                            <td>{{$pb->competition->name}}</td>
                                                            <td>{{$pb->mark}}</td>
                                                            <td>{{$pb->score}}</td>

                                                        </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">     
                                <div class="col-sm-12">            
                                   
                                    <!-- GRAPH TABS FOR PBS -->
                                    <div class="panel with-nav-tabs panel-default">
                                        <div class="panel-heading">
                                            Αναλυτική Πρόοδος ανά αγώνισμα
                                            <!-- TABS List -->
                                            <ul class="nav nav-tabs">
                                                @foreach($chartsResults as $event_id =>$chart)
                                                    <li @if(array_keys($chartsResults)[0]== $event_id) class="active" @endif><a href="#tabResult{{$event_id}}" data-toggle="tab">{{\App\Event::find($event_id)->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                @foreach($chartsResults as $event_id =>$chart)

                                                <div @if(array_keys($chartsResults)[0]== $event_id) class="tab-pane fade in active"@else class ="tab-pane fade" @endif id="tabResult{{$event_id}}">

                                                    <canvas id="resultsChart{{$event_id}}" width="400" height="200"></canvas>
                                                </div>
                                                @endforeach


                                            </div>
                                        </div>

                                    </div>
                                    <!-- -->

                                    <!-- GRAPH TABS FOR PBS -->
                                    <div class="panel with-nav-tabs panel-default">
                                        <div class="panel-heading">
                                            Πρόοδος προσωπικής καλύτερης επίδοσης (PB) ανά αγώνισμα
                                            <!-- TABS List -->
                                            <ul class="nav nav-tabs">
                                                @foreach($chartsPbs as $event_id =>$chart)
                                                    <li @if(array_keys($chartsPbs)[0]== $event_id) class="active" @endif><a href="#tabPb{{$event_id}}" data-toggle="tab">{{\App\Event::find($event_id)->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                @foreach($chartsPbs as $event_id =>$chart)

                                                <div @if(array_keys($chartsPbs)[0]== $event_id) class="tab-pane fade in active"@else class ="tab-pane fade" @endif id="tabPb{{$event_id}}">

                                                    <canvas id="pbsChart{{$event_id}}" width="400" height="200"></canvas>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- -->
                                </div>
                            </div>
                        </div>

                        <!-- ****************************************** -->
                        <!-- ****************************************** -->
                        <!-- ****************************************** -->
                        <!--              RESULTS TAB                   -->
                        <!-- ****************************************** -->
                        <!-- ****************************************** -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab2default">
                            <div class="col-sm-12">
                                <div class="panel with-nav-tabs panel-default">
                                    <div class="panel-heading">
                                        <ul class="nav nav-tabs">

                                          <li class="dropdown">
                                            <a href="#" data-toggle="dropdown">Χρονιά<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                @foreach($results as $key => $value)
                                                    <li><a href="#tab{{$key}}" data-toggle="tab">{{$key}}</a></li>
                                                @endforeach

                                            </ul>
                                          </li>
                                        </ul>
                                    </div>

                                    <div class="panel-body">
                                        <div class="tab-content">


                                        @foreach($results as $key => $value)

                                            <div class="tab-pane fade in active" id="tab{{$key}}">

                                                <div class="panel panel-default">
                                                    <div class="panel-heading">Αποτελέσματα {{$key}}</div>
                                                    <div class="panel-body">
                                                        <table class="table table-condensed table-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>Ημερομηνία</th>
                                                                    <th>Θέση</th>
                                                                    <th>Αγώνισμα</th>
                                                                    <th>Αγώνας</th>
                                                                    <th>Επίδοση</th>
                                                                    <th>Πόντοι</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="myTable">
                                                                @foreach($value as $result)
                                                                    <tr>
                                                                        <th scope="row">{{$result->date}}</th>
                                                                        <td>{{$result->position}}</th>
                                                                        <td>{{$result->event->name}} {{$result->event->season}}</td>
                                                                        <td>{{$result->competition->name}}</td>
                                                                        <th>{{$result->mark}}</td>
                                                                        <td>{{$result->score}}</td>

                                                                    </tr>

                                                                @endforeach
                                                            </tbody>

                                                        </table>

                                                    </div>
                                                </div>

                                            </div>

                                        @endforeach
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- ****************************************** -->
                        <!--              PHOTOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab3default">
                            Photos of athlete
                        </div>


                        <!-- ****************************************** -->
                        <!--              VIDEOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab4default">
                            Videos of athlete
                        </div>

                        <!-- ****************************************** -->
                        <!--              LINKS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tab5default">
                            @include('links.show', ['var' => $athlete])
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    //Pagination
  $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:4});


  /* CHARTS CODE */

  var chartsAll = {!! json_encode($chartsResults) !!};
  var chartsPB = {!! json_encode($chartsPbs) !!};

  var chart;


  for (chart in chartsPB) {
    var ctxPB = document.getElementById("pbsChart"+chart).getContext('2d');

    var rows = Object.keys(chartsPB[chart]);
    var collumns = Object.values(chartsPB[chart]);

    var myChart = new Chart(ctxPB, {
        type: 'line',
        data: {
            labels: rows,
            datasets: [{
                label: 'Επίδοση',
                data: timeToDecimal(collumns),
                borderColor: "#3e95cd",
                fill: false
            }]

        },
        options: {
            scales: {
                yAxes: [{

                }],
                xAxes: [{
                    type: 'time',
                    distribution: 'series'
                }]

            }
        }
    });

    }

  for (chart in chartsAll) {
    var ctxAll = document.getElementById("resultsChart"+chart).getContext('2d');

    var rows = Object.keys(chartsAll[chart]);
    var collumns = Object.values(chartsAll[chart]);
    console.log(rows,timeToDecimal(collumns));


    var myChart = new Chart(ctxAll, {
        type: 'line',
        data: {
            labels: rows,
            datasets: [{
                label: 'Επίδοση',
                data: timeToDecimal(collumns),
                borderColor: "#3e95cd",
                fill: false
            }]

        },

        options: {
            scales: {
                yAxes: [{


                }],

                xAxes: [{
                    type: 'time',
                    distribution: 'series'
                }]

            }

        }
    });

  }
});

function timeToDecimal(t) {


    var floatArray = [];
    t.forEach(function(item, index, array)  {
        var floatItem = item.split([':']);

        var time = item.split(/[.,:]/);
        var duration;
        if (time.length == 2){
            var duration = time[0]*1000 + time[1];
        }else if (time.length == 3){
            var duration = time[0]*60000 + time[1]*1000 + time[0];
        }else if (time.length == 4){
            var duration = time[0]*3600000 + time[0]*60000 + time[1]*1000 + time[0];
        }


        //console.log('duration ',duration);
        //console.log(moment.duration(item, "mm:ss:SS"));
        //console.log('date:',Date.parse(item));
        //console.log(moment().duration());

        /*
        floatItem.forEach(function(number, index2, array) {
            if (index2 == 0){
                floatArray[index] = number + '.';
            }else if (index2 == floatItem.length-1){
                floatArray[index] += number;
            }else{
                floatArray[index] += number+' ';
            }
        });
        */
        floatArray[index] = parseInt(duration);


    });

    return floatArray;
}



</script>
@endsection
