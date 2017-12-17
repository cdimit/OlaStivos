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
                {{Form::date('date', \Carbon\Carbon::now())}}

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


        <!--Event input field-->
        <div class="form-group{{ $errors->has('event_id') ? ' has-error' : '' }}">
            <label for="event_id" class="col-md-4 control-label">Event</label>
            <div class="col-md-6">
                <select  id="event_id" name="event_id" class="selectpicker" data-show-subtext="true" data-live-search="true">
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
                <input id="numberAthletes" type="number" max="100" min="1" required autofocus>
                <button id="numberAthletesButton" class="btn btn-primary">
                    Go
                </button>
            </div>
        </div>


        <div id="athletesTable">
            <table class="table table-bordered table-sm" style="position:static;">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Athlete</th>
                        <th>Mark</th>
                        <th>Score</th>
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
                        <td><input id="marks" name="marks[]" type="text" class="form-control" required></td></td>
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

        $('#numberAthletesButton').on('click',function(){


            var nathletes = $("#numberAthletes").val();

            for (i = 1; i <= nathletes; i ++)
            {
                var position =('<input id="positions" name="positions[]" type="text" value="" class="form-control" required></td>');
                var athlete = ('<select  id="athlete_ids" name="athlete_ids[]" class="selectpicker" data-show-subtext="true" data-live-search="true"> @foreach($athletes as $athlete) <option value="{{$athlete->id}}"> {{$athlete->first_name}} {{$athlete->last_name}}  {{$athlete->dob}} </option> @endforeach</select>');
                //var athlete = ('"'+document.getElementById("athletesRow").innerHTML +'"');
                var mark =  ('<input id="marks" name="marks[]" type="text" class="form-control" required></td>');
                var score =  ('<input id="scores" name="scores[]" type="number"  class="form-control" required></td>');               
                var deleteRow =  ('<span class="input-group-addon remove_field" id="basic-addon" style="width:5px; background-color:rgb(240,20,20);"><b>X</b></span>');
                console.log(position);
                $('#athletesTableBody').append('<tr>'+
                    '<td>'+ position +'</td>'+
                    '<td>'+ athlete+'</td>'+
                    '<td>'+ mark+'</td>'+
                    '<td>'+ score+'</td>'+
                    '<td>'+ deleteRow+'</td>'+
                    '</tr>');
                
            }

            $(".selectpicker").selectpicker();
        });



        $('#athletesRow').change(function(){ 
            var value = $(this).val();
        });

        $('#athletesTable').on("click",".remove_field", function(g){ //user click on remove text
            g.preventDefault(); 
            $(this).closest ('tr').remove ();
        })
    });
  </script>
@endsection
