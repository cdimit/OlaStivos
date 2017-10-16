@extends('layouts.app')
@section('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<style type="text/css">
    .form-horizontal{
        font-size: 11px;
    } 
    .form-horizontal .control-label{
        /* text-align:right; */
        text-align:left;

    }
    .form-group{
        margin-top:0px;
        margin-bottom: 0px;
    }

    label {
        line-height: 25px;
    }


    .form-control {
         width: auto; 
         height:auto; 
         font-size: 10px;
    }
</style>

@endsection

@section('content')
<div id="content" class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>National Records History</h2></div>               
                <div class="panel-body">

                    <!-- Search Form -->
                    <div class="col-lg-6 well"> 
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
                                <div class="col-xs-5 text-right">
                                    <label for="category">Age Category</label>
                                </div>
                                <div class="col-xs-7">
                                    <select  id="category" name="category" class="form-control" style="width: auto; height:auto; font-size: 10px; overflow: hidden;">
                                        <option value="Senior">Senior</option>
                                        <option value="U23">U23</option>
                                        <option value="Junior">Junior</option>
                                        <option value="Youth">Youth</option>
                                    </select>
                                </div>
                            </div>
                          
                            <div class="form-group">
                                <div class="col-xs-5 text-right">
                                    <label for="season">Season</label>
                                </div>
                                <div class="col-xs-7">
                                    <select  id="season" name="season" class="form-control">
                                        <option value="outdoor">Outdoor</option>
                                        <option value="indoor">Indoor</option>
                                        <option value="road">Road</option>
                                        <option value="cross country">Cross Country</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-5 text-right">
                                    <label for="gender">Gender</label>
                                </div>
                                <div class="col-xs-7">
                                    <select  id="gender" name="gender" class="form-control" required>
                                        <option value="" disabled selected>Select your option</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div id="event_select" class="form-group">
                                <div class="col-xs-5 text-right">
                                    <label for="event">Event</label>
                                </div>
                                <div class="col-xs-7">
                                    <select  id="event" name="event" class="form-control"  required>
                                        <option id='1' value="">-- select one -- </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-10 col-xs-offset-2">
                                <div class="form-group" style="margin-top:5px; margin-bottom: 1px;">
                                    <button id="submit" type="submit" class="btn btn-default" >Find History of Record</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                    <!-- Main Content -->
                    
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
                    </div>
                   
                    
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
                console.log(response.data);

                $.each(response.data, function( index, value ) {
                    console.log( index + ": " + value.id );
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

});
</script>
@endsection
