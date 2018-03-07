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
                <h1>Πόντοι</h1>
                <div class="well">
                    <h4>Εισάγετε δεδομένα για το στατιστικό που σας ενδιαφέρει:</h4>
                    {!! Form::open(
                            array(
                                'route' => 'scorelist.search',
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
                                  <option value="all">Όλες</option>
                                  @foreach($years as $year)
                                    <option value="{{$year}}" @if($selected[0]==$year) selected @endif>{{$year}}</option>
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
                                    <option value="{{$age->id}}" @if($selected[1]==$age->id) selected @endif>{{$age->name}}</option>
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
                                    <option value="outdoor" @if($selected[2]=='outdoor') selected @endif>Ανοικτός</option>
                                    <option value="indoor" @if($selected[2]=='indoor') selected @endif>Κλειστός</option>
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
                                    <option value="all" @if($selected[3]=='all') selected @endif>Μαζί</option>
                                    <option value="male" @if($selected[3]=='male') selected @endif>Άνδρες</option>
                                    <option value="female" @if($selected[3]=='female') selected @endif>Γυναίκες</option>
                                </select>
                            </div>

                        </div>

                        <div id="event_select" class="form-group">
                            <div class="col-xs-5 text-left">
                                <label for="event">Αγωνίσματα</label>
                            </div>
                            <div class="col-xs-7">
                                <select  id="event" name="event" class="form-control"  required>
                                    <option value="all" @if($selected[4]=='all') selected @endif>Όλα</option>
                                    <option value="track" @if($selected[4]=='track') selected @endif>Track</option>
                                    <option value="field" @if($selected[4]=='field') selected @endif>Field</option>
                                </select>
                            </div>
                        </div>
{{--
                        <div class="form-group">
                            <div class="col-xs-5 text-left">
                                <label for="season">Ένα αποτέλεσμα ανά αθλητή:</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="checkbox" id="unique" class="form-control">
                            </div>

                        </div> --}}

                        <div class="form-group" style="margin-top:5px; margin-bottom: 5px;">
                            <div class="col-xs-10 col-xs-offset-2">
                                <button id="submit" type="submit" class="btn btn-default" >Βρές τα στατιστικά</button>
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
                        <label for="unique">*Ένα αποτέλεσμα ανά αθλητή:</label>
                        <input type="checkbox" id="unique">

                        <div class="col-md-12">

                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <div class="table table-responsive">
                                    <table width="100%">
                                      <th>Κατάταξη</th>
                                      <th>Πόντοι</th>
                                      <th>Αγώνισμα</th>
                                      <th>Επίδοση</th>
                                      <th>Αθλητής</th>
                                      <th>Σύλλογος</th>
                                      <th>Τοποθεσία</th>
                                      <th>Ημερομηνία</th>

                                      <?php $count=0;
                                            $check = collect([]);
                                            $check->put(0,0);
                                            $score = 0;
                                            $index = 0;
                                      ?>
                                        @foreach($results->where('is_recordable', true) as $result)
                                          <?php
                                            $ath = $check->get($result->athlete->id);
                                            if(!$ath || $ath!=$result->event->id){
                                              $check->put($result->athlete->id, $result->event->id);
                                              if($score==$result->score){
                                                $rank = $count;
                                                $index++;
                                              }else{
                                                $score = $result->score;
                                                $count = $count + $index + 1;
                                                $index = 0;
                                                $rank = $count;
                                              }
                                            }else{
                                              $rank = '-';
                                            }
                                          ?>
                                            <tr class={{$rank}}>
                                                <td>{{$rank}}</td>
                                                <td>{{$result->score}}</td>
                                                <td>{{$result->event->name}}</td>
                                                <td>{{$result->markstr}}</td>
                                                <td>
                                                <a href="/athlete/{{$result->athlete->id}}">
                                                {{$result->athlete->name}}</a>
                                                </td>
                                                <td>
                                                  <a href="/club/{{optional($result->athlete->club)->id}}">{{optional($result->athlete->club)->acronym}}</a>
                                                </td>
                                                <td>
                                                  <a href="/competition/{{$result->competition->id}}">{{$result->competition->city}}</a>
                                                </td>
                                                <td>{{date('d M Y', strtotime($result->date))}}</td>

                                            </tr>

                                        @endforeach

                                    </table>
                                    </div>
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


@endsection
