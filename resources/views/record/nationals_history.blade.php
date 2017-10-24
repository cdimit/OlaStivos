@extends('layouts.app')
@section('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<style type="text/css">
    .form-horizontal{
        font-size: 12px;
    } 
    .form-horizontal .control-label{
        /* text-align:right; */
        text-align:left;

    }

    .form-group{
        margin-top:1px;
        margin-bottom: 1px;
    }

    label {
        line-height: 28px;
        color: black;
        font-style:bold;
    }

    h1{
        color: white;
        font-weight: bold;
        margin-top: 40px;
        margin-bottom: 20px;  
        text-shadow: -0.5px 0 black, 0 0.5px black, 0.5px 0 black, 0 -0.5px black;
    }
    h4{
        color: black;
        margin-top: 0px;
    }

    .well {
       background-color: rgba(245, 245, 245, 0.4);
       margin-left: 1px;
       margin-right: 1px;
       margin-top: 1px;
       margin-bottom: 1px;
       border: 0;
    }

    .form-control {
         width: auto; 
         height:auto; 
         font-size: 10px;
    }

    .image-back {
        background: url(https://images.pexels.com/photos/332835/pexels-photo-332835.jpeg?w=940&h=650&auto=compress&cs=tinysrgb) no-repeat;
        min-height: 300px;
        margin-top: 51px;

    }


</style>

@endsection

@section('content')
<div id="content" class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

             <!-- Heading and Search Form -->
            <div class="col-lg-12 image-back">
                <h1>National Records History</h1>
                <div class="col-md-6 well">
                <h4>Input National Record to find its history:</h4>
                {!! Form::open(
                        array(
                            'route' => 'record.searchNRsHistory', 
                            'class' => 'form-horizontal'
                            )
                        ) 
                    !!}
                    
                    {{ csrf_field() }} 

                    <div class="form-group">
                        <div class="col-xs-4 text-left">
                            <label for="category">Age Category</label>
                        </div>
                        <div class="col-xs-8">
                            <select  id="category" name="category" class="form-control" style="width: auto; height:auto; font-size: 10px; overflow: hidden;">
                                <option value="Senior">Senior</option>
                                <option value="U23">U23</option>
                                <option value="Junior">Junior</option>
                                <option value="Youth">Youth</option>
                            </select>
                        </div>

                    </div>
                  
                    <div class="form-group">
                        <div class="col-xs-4 text-left">
                            <label for="season">Season</label>
                        </div>
                        <div class="col-xs-8">
                            <select  id="season" name="season" class="form-control">
                                <option value="outdoor">Outdoor</option>
                                <option value="indoor">Indoor</option>
                                <option value="road">Road</option>
                                <option value="cross country">Cross Country</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <div class="col-xs-4 text-left">
                            <label for="gender">Gender</label>
                        </div>
                        <div class="col-xs-8">
                            <select  id="gender" name="gender" class="form-control" required>
                                <option value="" disabled selected>Select your option</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                  
                    </div>

                    <div id="event_select" class="form-group">
                        <div class="col-xs-4 text-left">
                            <label for="event">Event</label>
                        </div>
                        <div class="col-xs-8">
                            <select  id="event" name="event" class="form-control"  required>
                                <option id='1' value="">-- select one -- </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:5px; margin-bottom: 5px;">
                        <div class="col-xs-10 col-xs-offset-2">
                            <button id="submit" type="submit" class="btn btn-default" >Find History of Record</button>
                        </div>
                    </div>
                {!! Form::close() !!}
                </div>
            </div>



            <div class="panel panel-default">
                <div class="panel-body">
                   
                    <!-- Main Content -->
                    @if($event)
                    
                    <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading"><h3>{{$event->name}} {{$event->gender}} {{$category}} Records - {{strtoupper($season)}}</h3></div>
                            <div class="panel-body">
                                <table width="100%">
                                    @foreach($records as $record)

                                        <tr>
                                            <td>{{$record->event->name}}</td>
                                            <td>
                                            <a href="/athlete/{{$record->athlete->id}}">
                                            {{$record->athlete->first_name}} {{$record->athlete->last_name}}</a>
                                            </td>
                                            <td>{{$record->date}}</td>
                                            <td>{{$record->mark}}</td>
                                        </tr>

                                    @endforeach

                                </table> 
                            </div>
                        </div>
                        <div id="chart1" style="width:100%; height:200px;"></div>
                    </div>
                    @endif                   
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript">
    jQuery(document).ready(function(){


        $('#submit').hide();
        $('#event_select').hide();
        
        $('#gender').on('change',function(){
            getEvents();
        });

        $('#season').on('change',function(){
            getEvents();
        });

        


        /* Functions */
        function getEvents() {
            document.getElementById('event').innerHTML = "";
            if( $('#gender').val()==="male" || $('#gender').val()==="female" ){
                var myUrl = '/records/nationals/history/events';
                var myData = {
                  gender: $('#gender').val(),
                  season: $('#season').val(), 
                };
                var events;

                axios.post(myUrl, myData )
                .then(function (response) {
                    $.each(response.data, function( index, value ) {
                        $('#event').append($('<option>', {
                            value: value.id,
                            text: value.name
                        }));  
                    });
                })
                .catch(function (error) {
                    console.log('error');
                });
                $("#submit").show();
                $("#event_select").show();
            }else{
                $("#submit").hide();
                $("#event_select").hide();
            }
            return;
        }
        $(function () { 
            var chartData =  <?php echo json_encode($chartRecords); ?>;;
            console.log(chartData);
            var dates = Object.keys(chartData);
            var marks = Object.values(chartData);

            var myChart = Highcharts.chart('chart1', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Dummy Data - Record History'
                },
                xAxis: {
                    type: 'datetime'
                },
                yAxis: {

                },
                series: [{
                    data: [1,2,3,5],
                    showInLegend: false,  
                }],
            });
        });

    });

</script>
@endsection
