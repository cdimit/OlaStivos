@extends('layouts.app')
@section('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <link href="{{ asset('/css/forms/form-in-well.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/headings/heading-in-pages.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/images/img-in-div.css') }}" rel="stylesheet">

@endsection

@section('content')
<div id="content" class="container" style="background-color: #F9F9F9;">
    <div class="row">

        <div class="col-md-12">
            <div class="col-md-6">
                <h1>Τοπ Λίστες</h1>
                <div class="well">
                    <h4>Εισάγετε δεδομένα για τη χρονιά που σας ενδιαφέρει:</h4>
                    {!! Form::open(
                            array(
                                'route' => 'toplist.search',
                                'class' => 'form-horizontal'
                                )
                            )
                        !!}

                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-xs-5 text-left">
                                <label for="year">Χρονιά</label>
                            </div>
                            <div class="col-xs-7">
                                <select  id="year" name="year" class="form-control" style="width: auto; height:auto; font-size: 10px; overflow: hidden;">
                                  @foreach($years as $year)
                                    <option value="{{$year}}">{{$year}}</option>
                                  @endforeach
                                </select>
                            </div>

                        </div>

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

                        <div class="form-group">
                            <div class="col-xs-5 text-left">
                                <label for="season">Ένα αποτέλεσμα ανά αθλητή:</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="checkbox" id="unique" class="form-control">
                            </div>

                        </div>

                        <div class="form-group" style="margin-top:5px; margin-bottom: 5px;">
                            <div class="col-xs-10 col-xs-offset-2">
                                <button id="submit" type="submit" class="btn btn-default" >Βρές κορυφαίες επιδόσεις</button>
                            </div>
                        </div>
                    {!! Form::close() !!}


                </div>
            </div>
            <div class="col-md-6">
                <img class="img-in-div"  src="https://images.pexels.com/photos/332835/pexels-photo-332835.jpeg?w=940&h=650&auto=compress&cs=tinysrgb">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <!-- Main Content -->
                    @if($results)
                        <h3>{{$event->name}} {{$event->gender}} Top-List</h3>
                        <div class="col-md-12">

                            <div class="panel panel-default">

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

        $('#year').on('change',function(){
            getEvents();
        });




        /* Functions */
        function getEvents() {
            document.getElementById('event').innerHTML = "";
            if( $('#gender').val()==="male" || $('#gender').val()==="female" ){
                var myUrl = '/toplist/events';
                var myData = {
                  gender: $('#gender').val(),
                  season: $('#season').val(),
                  age: $('#age').val(),
                  year: $('#year').val(),
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
