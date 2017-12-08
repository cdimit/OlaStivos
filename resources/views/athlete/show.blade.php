@extends('layouts.app')
@section('styles')

{{--     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>

 --}}
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
<div class="container" style="min-height: calc(100vh - 400px);">
    <div class="row">
        <div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <!-- TABS List -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tabmain" data-toggle="tab">Πληροφορίες</a></li>
                            <li><a href="#tabresults" data-toggle="tab">Αποτελέσματα</a></li>
                            <li><a href="#tabphotos" data-toggle="tab">Φωτογραφίες</a></li>
                            <li><a href="#tabvideos" data-toggle="tab">Βίντεο</a></li>
                            <li><a href="#tablinks" data-toggle="tab">Σύνδεσμοι</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">

                        <!-- ****************************************** -->
                        <!--                MAIN TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade in active" id="tabmain">
                            @include('athlete.main_tab')
                        </div>

                        <!-- ****************************************** -->
                        <!-- ****************************************** -->
                        <!-- ****************************************** -->
                        <!--              RESULTS TAB                   -->
                        <!-- ****************************************** -->
                        <!-- ****************************************** -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tabresults">
                            @include('athlete.result_tab')
                    
                        </div>


                        <!-- ****************************************** -->
                        <!--              PHOTOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tabphotos">
                            <h3>Φωτογραφίες Αθλητή</h3>
                            @if($athlete->images->first())
                                @include('gallery.images', ['var' => $athlete])
                            @endif
                        </div>


                        <!-- ****************************************** -->
                        <!--              VIDEOS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tabvideos">
                            <h3>Βίντεο Αθλητή</h3>
                            @if($athlete->videos->first())
                                @include('gallery.videos', ['var' => $athlete])
                            @endif
                        </div>

                        <!-- ****************************************** -->
                        <!--              LINKS TAB                    -->
                        <!-- ****************************************** -->
                        <div class="tab-pane fade" id="tablinks">
                            <h3>Σύνδεσμοι Αθλητή</h3>
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
// $(document).ready(function(){
//     //Pagination
//   $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:4});


//   /* CHARTS CODE */

//   var chartsAll = {!! json_encode($chartsResults) !!};
//   var chartsPB = {!! json_encode($chartsPbs) !!};

//   var chart;


//   for (chart in chartsPB) {
//     var ctxPB = document.getElementById("pbsChart"+chart).getContext('2d');

//     var rows = Object.keys(chartsPB[chart]);
//     var collumns = Object.values(chartsPB[chart]);

//     var myChart = new Chart(ctxPB, {
//         type: 'line',
//         data: {
//             labels: rows,
//             datasets: [{
//                 label: 'Επίδοση',
//                 data: timeToDecimal(collumns),
//                 borderColor: "#3e95cd",
//                 fill: false
//             }]

//         },
//         options: {
//             scales: {
//                 yAxes: [{

//                 }],
//                 xAxes: [{
//                     type: 'time',
//                     distribution: 'series'
//                 }]

//             }
//         }
//     });

//     }

//   for (chart in chartsAll) {
//     var ctxAll = document.getElementById("resultsChart"+chart).getContext('2d');

//     var rows = Object.keys(chartsAll[chart]);
//     var collumns = Object.values(chartsAll[chart]);
//     console.log(rows,timeToDecimal(collumns));


//     var myChart = new Chart(ctxAll, {
//         type: 'line',
//         data: {
//             labels: rows,
//             datasets: [{
//                 label: 'Επίδοση',
//                 data: timeToDecimal(collumns),
//                 borderColor: "#3e95cd",
//                 fill: false
//             }]

//         },

//         options: {
//             scales: {
//                 yAxes: [{


//                 }],

//                 xAxes: [{
//                     type: 'time',
//                     distribution: 'series'
//                 }]

//             }

//         }
//     });

//   }
// });

// function timeToDecimal(t) {


//     var floatArray = [];
//     t.forEach(function(item, index, array)  {
//         var floatItem = item.split([':']);

//         var time = item.split(/[.,:]/);
//         var duration;
//         if (time.length == 2){
//             var duration = time[0]*1000 + time[1];
//         }else if (time.length == 3){
//             var duration = time[0]*60000 + time[1]*1000 + time[0];
//         }else if (time.length == 4){
//             var duration = time[0]*3600000 + time[0]*60000 + time[1]*1000 + time[0];
//         }


//         //console.log('duration ',duration);
//         //console.log(moment.duration(item, "mm:ss:SS"));
//         //console.log('date:',Date.parse(item));
//         //console.log(moment().duration());

//         /*
//         floatItem.forEach(function(number, index2, array) {
//             if (index2 == 0){
//                 floatArray[index] = number + '.';
//             }else if (index2 == floatItem.length-1){
//                 floatArray[index] += number;
//             }else{
//                 floatArray[index] += number+' ';
//             }
//         });
//         */
//         floatArray[index] = parseInt(duration);


//     });

//     return floatArray;
// }



</script>
@endsection
