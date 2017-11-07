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
                <h1>Top List</h1>
                <div class="col-md-6 well">
                <h4>Εισάγετε Παγκύπριο Ρεκόρ για να δείτε την πρόοδο του:</h4>
                {!! Form::open(
                        array(
                            'route' => 'alltime.search',
                            'class' => 'form-horizontal'
                            )
                        )
                    !!}

                    {{ csrf_field() }}


                    <div class="form-group">
                        <div class="col-xs-5 text-left">
                            <label for="age">Ηλικιακή Κατηγορία</label>
                        </div>
                        <div class="col-xs-7">
                            <select  id="age" name="age" class="form-control" style="width: auto; height:auto; font-size: 10px; overflow: hidden;">
                              @foreach($ages as $age)
                                <option value="{{$age->id}}">{{$age->name}}</option>
                              @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-xs-5 text-left">
                            <label for="season">Σεζόν</label>
                        </div>
                        <div class="col-xs-7">
                            <select  id="season" name="season" class="form-control">
                                <option value="outdoor">Ανοικτός</option>
                                <option value="indoor">Κλειστός</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-xs-5 text-left">
                            <label for="gender">Φύλο</label>
                        </div>
                        <div class="col-xs-7">
                            <select  id="gender" name="gender" class="form-control" required>
                                <option value="" disabled selected>Select your option</option>
                                <option value="male">Άνδρες</option>
                                <option value="female">Γυναίκες</option>
                            </select>
                        </div>

                    </div>

                    <div id="event_select" class="form-group">
                        <div class="col-xs-5 text-left">
                            <label for="event">Αγωνισμα</label>
                        </div>
                        <div class="col-xs-7">
                            <select  id="event" name="event" class="form-control"  required>
                                <option id='1' value="">-- select one -- </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:5px; margin-bottom: 5px;">
                        <div class="col-xs-10 col-xs-offset-2">
                            <button id="submit" type="submit" class="btn btn-default" >Βρές προιστορία ρεκόρ</button>
                        </div>
                    </div>
                {!! Form::close() !!}

                <input type="checkbox" id="unique">Unique
                </div>
            </div>



            <div class="panel panel-default">
                <div class="panel-body">

                    <!-- Main Content -->
                    @if($results)
                        <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-heading"><h3>{{$event->name}} {{$event->gender}} Top-List</h3></div>
                                <div class="panel-body">
                                    <table width="100%">
                                      <th>Rank</th>
                                      <th>Mark</th>
                                      <th>Athlete</th>
                                      <th>Club</th>
                                      <th>Position</th>
                                      <th>Competition</th>
                                      <th>Place</th>
                                      <th>Date</th>

                                      <?php $count=1;
                                            $check = collect([]);
                                            $check->push(0);

                                      ?>
                                        @foreach($results as $result)
                                          <?php
                                            if(!$check->search($result->athlete->id, true)){
                                              $check->push($result->athlete->id);
                                              $rank = $count;
                                              $count++;
                                            }else{
                                              $rank = '-';
                                            }
                                          ?>
                                            <tr class={{$rank}}>
                                                <td>{{$rank}}</td>
                                                <td>{{$result->mark}}</td>
                                                <td>
                                                <a href="/athlete/{{$result->athlete->id}}">
                                                {{$result->athlete->first_name}} {{$result->athlete->last_name}}</a>
                                                </td>
                                                <td>
                                                  <a href="/club/{{$result->athlete->club->id}}">{{$result->athlete->club->acronym}}</a>
                                                </td>
                                                <td>{{$result->position}}</td>
                                                <td>
                                                  <a href="/competition/{{$result->competition->id}}">{{$result->competition->name}}</a>
                                                </td>
                                                <td>{{$result->competition->city}}, {{$result->competition->country}}</td>
                                                <td>{{$result->date}}</td>

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

  <script>
  $(document).ready(function(){
    $('#unique').on('change',function(){
        $(".-").toggle();
    });
  });
  </script>

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

        $('#age').on('change',function(){
            getEvents();
        });




        /* Functions */
        function getEvents() {
            document.getElementById('event').innerHTML = "";
            if( $('#gender').val()==="male" || $('#gender').val()==="female" ){
                var myUrl = '/alltime/events';
                var myData = {
                  gender: $('#gender').val(),
                  season: $('#season').val(),
                  age: $('#age').val(),
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



    });

</script>
@endsection
