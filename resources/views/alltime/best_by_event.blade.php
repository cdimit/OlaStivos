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
                <h1>Κορυφαίες επιδόσεις όλων των εποχών</h1>
                <div class="well">
                    <h4>Εισάγετε δεδομένα για το αγώνισμα που σας ενδιαφέρει:</h4>
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
                                <button id="submit" type="submit" class="btn btn-default" >Βρές κορυφαίες επιδόσεις</button>
                            </div>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
            <div class="col-md-6">
                <img class="img-in-div"  src="/img/collage2.jpg">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <!-- Main Content -->
                    @if($results->where('is_recordable', true)->first())
                        <h3>{{$event->name}} {{$event->gender}} Top-List</h3>
                        <label for="unique">*Ένα αποτέλεσμα ανά αθλητή:</label>
                        <input type="checkbox" id="unique">
                        <div class="col-md-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <table width="100%">
                                      <th>Κατάταξη</th>
                                      <th>Επίδοση</th>
                                      <th>Άνεμος</th>
                                      <th>Αθλητής</th>
                                      <th>Σύλλογος</th>
                                      <th>Τοποθεσία</th>
                                      <th>Ημερομηνία</th>

                                      <?php $count=1;
                                            $check = collect([]);
                                            $check->push(0);

                                      ?>
                                        @foreach($results->where('is_recordable', true) as $result)
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
                                                <td>{{$result->markstr}}</td>
                                                <td>{{$result->wind}}</td>
                                                <td>
                                                <a href="/athlete/{{$result->athlete->id}}">
                                                {{$result->athlete->first_name}} {{$result->athlete->last_name}}</a>
                                                </td>
                                                <td>
                                                  <a href="/club/{{$result->athlete->club->id}}">{{$result->athlete->club->acronym}}</a>
                                                </td>
                                                <td>
                                                  <a href="/competition/{{$result->competition->id}}">{{$result->competition->city}}</a>
                                                </td>
                                                <td>{{$result->date}}</td>

                                            </tr>

                                        @endforeach

                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Main Content -->
                    @if($results->where('is_recordable', false)->first())
                        <div class="col-md-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <table width="100%">
                                      <th>Κατάταξη</th>
                                      <th>Επίδοση</th>
                                      <th>Άνεμος</th>
                                      <th>Αθλητής</th>
                                      <th>Σύλλογος</th>
                                      <th>Θέση</th>
                                      <th>Αγώνας</th>
                                      <th>Τοποθεσία</th>
                                      <th>Ημερομηνία</th>

                                      <h4>Μη αναγνωρισμένες επιδόσης</h4>
                                        @foreach($results->where('is_recordable', false) as $result)

                                            <tr class='-'>
                                                <td>-</td>
                                                <td>{{$result->markstr}}</td>
                                                <td>{{$result->wind}}</td>
                                                <td>
                                                <a href="/athlete/{{$result->athlete->id}}">
                                                {{$result->athlete->name}}</a>
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
