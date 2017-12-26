@extends('layouts.dashboard')

@section('content')

    <p><u><h4>Add New Race Results</h4></u></p>
    {!! Form::open(
        array(
            'route' => 'result.storeRace',
            'class' => 'form-horizontal'
            )
        )
    !!}
    {{ csrf_field() }}

        <!--Competition input field-->
        <div class="form-group{{ $errors->has('competition_id') ? ' has-error' : '' }}">
            <label for="competition_id" class="col-md-4 control-label">Competition</label>
            <div class="col-md-6">
                <select  id="competition_id" name="competition_id" class="selectpicker" data-show-subtext="true" data-live-search="true">
                    @foreach($competitions as $competition)
                        <option value="{{$competition->id}}">{{$competition->name}} {{$competition->date_start}}</option>
                    @endforeach
                </select>
                @if ($errors->has('competition_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('competition_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--date input field-->
        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            <label for="date" class="col-md-4 control-label">Date</label>
            <div class="col-md-6">
                <select  id="date" name="date" >

                </select>

                @if ($errors->has('date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Race input field-->
        <div class="form-group{{ $errors->has('race') ? ' has-error' : '' }}">
            <label for="race" class="col-md-4 control-label">Race</label>
            <div class="col-md-6">
                {{ Form::text('race',null,["class"=> 'form-control','placeholder'=>'Heat, Semi-final...','required'])}}

                @if ($errors->has('race'))
                    <span class="help-block">
                        <strong>{{ $errors->first('race') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <!--Event Type input field-->
        <div class="form-group">
            <label for="type" class="col-md-4 control-label">Event Type</label>
            <div class="col-md-6">
                <select  id="type" name="type" class="selectpicker" >
                    @foreach($events->pluck('type')->unique() as $type)
                        <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                </select>
                @if ($errors->has('event_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <!--Event input field-->
        <div class="form-group{{ $errors->has('event_id') ? ' has-error' : '' }}">
            <label for="event_id" class="col-md-4 control-label">Event</label>
            <div class="col-md-6">
                <select  id="event_id" name="event_id" >
                    @foreach($events as $event)
                        <option value="{{$event->id}}">{{$event->name}} {{$event->season}} {{$event->gender}}</option>
                    @endforeach
                </select>
                @if ($errors->has('event_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Wind input field-->
        <div class="form-group{{ $errors->has('wind') ? ' has-error' : '' }}">
            <label for="wind" class="col-md-4 control-label">Wind</label>
            <div class="col-md-6">
                <input id="wind" type="text" class="form-control" name="wind" value="{{ old('wind') }}" >

                @if ($errors->has('wind'))
                    <span class="help-block">
                        <strong>{{ $errors->first('wind') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="numberAthletes" class="col-md-4 control-label">Add Number of Athletes</label>
            <div class="col-md-6">
                <input id="numberAthletes" type="number" max="100" min="1" >
                <button id="numberAthletesButton" class="btn btn-primary">
                    Go
                </button>
            </div>
        </div>


        <div id="athletesTable">
            <table class="table table-bordered table-sm" style="position:static;">
                <thead>
                    <tr>
                        <th width="10%">Pos.</th>
                        <th width="30%">Athlete</th>
                        <th width="45%">Mark</th>
                        <th width="15%">Score</th>
                    </tr>
                </thead>
                <tbody id="athletesTableBody">
                    <tr>
                        <td><input id="positions" name="positions[]" type="text" class="form-control" required></td></td>
                        <td><select  id="athlete_ids" name="athlete_ids[]" class="selectpicker" data-show-subtext="true" data-live-search="true"> 
                            @foreach($athletes as $athlete) 
                                <option value="{{$athlete->id}}"> 
                                    {{$athlete->first_name}} {{$athlete->last_name}}  {{$athlete->dob}} 
                                </option> 
                            @endforeach
                            </select>
                        </td>
                        <td>
                            <!-- Input fields for field events -->
                            <div class="field_mark">
                                <div class="col-md-6">
                                    <input id="meters" type="number" class="form-control" name="meters[]"  step="1" min="0" placeholder="m">
                                </div>
                                <div class="col-md-6">
                                    <input id="cmeters" type="number" class="form-control" name="cmeters[]" step="1" min="0" max="99" placeholder="cm">
                                </div>
                            </div>
                            <!-- Input fields for track events -->
                            <div class="track_mark">
                                <div class="input-group" style="display: block;">
                                    <input id="hours" type="number" class="form-control" name="hours[]"  step="1" min="0" placeholder="h"  style="display:inline; width:5vw;">
                                    <input id="minutes" type="number" class="form-control" name="minutes[]" step="1" min="0" max="59" placeholder="min" style="display:inline; width:5vw;">
                                    <input id="seconds" type="number" class="form-control" name="seconds[]" step="1" min="0" max="59" placeholder="sec" style="display:inline; width:5vw;">
                                    <input id="decimal" type="number" class="form-control" name="decimal[]" step="1" min="0" max="99" placeholder="00" style="display:inline; width:5vw;">
                                </div>
                            </div>
                        </td>
                        <td><input id="scores" name="scores[]" type="number"  class="form-control" required></td></td>
                        <td></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>


        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{ route('result.index') }}">Cancel</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Save Result
                </button>
            </div>
        </div>


    {!! Form::close() !!}
@endsection
@section('scripts')

  <script type="text/javascript">

    $(function() {


        getDates();
        getEvents();//gets events based on type
        markInput();//changes types of fields to put the mark



        $('#numberAthletesButton').on('click',function(){
            var nathletes = $("#numberAthletes").val();

            for (i = 1; i <= nathletes; i ++)
            {
                var position =('<input id="positions" name="positions[]" type="text" value="" class="form-control" required></td>');
                var athlete = ('<select  id="athlete_ids" name="athlete_ids[]" class="selectpicker" data-show-subtext="true" data-live-search="true"> @foreach($athletes as $athlete) <option value="{{$athlete->id}}"> {{$athlete->first_name}} {{$athlete->last_name}}  {{$athlete->dob}} </option> @endforeach</select>');
                //var athlete = ('"'+document.getElementById("athletesRow").innerHTML +'"');
                
                var marks=('<div class="field_mark"><div class="col-md-6"><input id="meters" type="number" class="form-control" name="meters[]"  step="1" min="0" placeholder="m"></div><div class="col-md-6"><input id="cmeters" type="number" class="form-control" name="cmeters[]" step="1" min="0" max="99" placeholder="cm"></div></div><div class="track_mark"><div class="input-group" style="display: block;"><input id="hours" type="number" class="form-control" name="hours[]"  step="1" min="0" placeholder="h"  style="display:inline; width:5vw;"><input id="minutes" type="number" class="form-control" name="minutes[]" step="1" min="0" max="59" placeholder="min" style="display:inline; width:5vw;"><input id="seconds" type="number" class="form-control" name="seconds[]" step="1" min="0" max="59" placeholder="sec" style="display:inline; width:5vw;"><input id="decimal" type="number" class="form-control" name="decimal[]" step="1" min="0" max="99" placeholder="00" style="display:inline; width:5vw;"></div></div>')

                var score =  ('<input id="scores" name="scores[]" type="number"  class="form-control" required></td>');               
                var deleteRow =  ('<span class="input-group-addon remove_field" id="basic-addon" style=" color:rgb(240,20,20);"><b>x</b></span>');
                console.log(position);
                $('#athletesTableBody').append('<tr>'+
                    '<td>'+ position +'</td>'+
                    '<td>'+ athlete+'</td>'+
                    '<td>'+ marks +'</td>'+
                    '<td>'+ score+'</td>'+
                    '<td>'+ deleteRow+'</td>'+
                    '</tr>');
                
            }
            markInput();
            $(".selectpicker").selectpicker();
        });



        $('#athletesRow').change(function(){ 
            var value = $(this).val();
        });

        $('#athletesTable').on("click",".remove_field", function(g){ //user click on remove text
            g.preventDefault(); 
            $(this).closest ('tr').remove ();
        });

        
        $('#competition_id').on('change',function(){
            getDates();
        });

        //if the type of the event changes
        //then the events are different
        //and the inputs change
        $('#type').on('change',function(){
            getEvents();
            markInput();
        });

        /* Functions */
        function getEvents() {
            document.getElementById('event_id').innerHTML = "";

            var myUrl = '/dashboard/result/events';
            var myData = {
                type: $('#type').val(),
            };
            var events;

            axios.post(myUrl, myData ).then(function (response) {
                $.each(response.data, function( index, value ) {
                  $('#event_id').append($('<option>', {
                      value: value.id,
                      text: value.name + ' ' + value.season + ' ' + value.gender
                  }));
                });
            })
              .catch(function (error) {
                    console.log('error');
            });
            return;
        } 

        function markInput() {
          if( $('#type').val()==="field" ){
              $(".field_mark").show();
              $(".track_mark").hide();
          }else{
              $(".field_mark").hide();
              $(".track_mark").show();
          }

          return;
        }

        function getDates() {
            document.getElementById('date').innerHTML = "";

            var myUrl = '/dashboard/result/dates';
            var myData = {
                competition: $('#competition_id').val(),
            };
            var dates;

            axios.post(myUrl, myData ).then(function (response) {
                $.each(response.data, function( index, value ) {
                    $('#date').append('<option value="'+value+'">'+value+'</option>');
                    console.log(value);
                });
            })
            .catch(function (error) {
                console.log('error');
            });
            return;
          }

    });
  </script>
@endsection
