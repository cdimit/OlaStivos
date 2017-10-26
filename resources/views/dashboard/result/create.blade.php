@extends('layouts.dashboard')
@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
@endsection


@section('content')

    <p><u><h4>Add New Result</h4></u></p>
    {!! Form::open(
        array(
            'route' => 'result.store',
            'class' => 'form-horizontal'
            )
        )
    !!}

    {{ csrf_field() }}

        <!--Position input field-->
        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
            <label for="position" class="col-md-4 control-label">Position</label>
            <div class="col-md-6">
                <input id="position" type="text" class="form-control" name="position" value="{{ old('position') }}" required autofocus>

                @if ($errors->has('position'))
                    <span class="help-block">
                        <strong>{{ $errors->first('position') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Athlete input field-->
        <div class="form-group{{ $errors->has('athlete_id') ? ' has-error' : '' }}">
            <label for="athlete_id" class="col-md-4 control-label">Athlete</label>
            <div class="col-md-6">
                <select  id="athlete_id" name="athlete_id" class="selectpicker" data-show-subtext="true" data-live-search="true">
                    @foreach($athletes as $athlete)
                        <option value="{{$athlete->id}}">{{$athlete->first_name}} {{$athlete->last_name}} {{$athlete->dob}}</option>
                    @endforeach
                </select>
                @if ($errors->has('athlete_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('athlete_id') }}</strong>
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

        <!--Mark input field-->
        <div class="form-group{{ $errors->has('mark') ? ' has-error' : '' }}">
            <label for="mark" class="col-md-4 control-label">Mark</label>
            <div class="col-md-6">
                <input id="mark" type="text" class="form-control" name="mark" value="{{ old('mark') }}" required>

                @if ($errors->has('mark'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mark') }}</strong>
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

        <!--Score input field-->
        <div class="form-group{{ $errors->has('score') ? ' has-error' : '' }}">
            <label for="result" class="col-md-4 control-label">Score Points</label>
            <div class="col-md-6">
                <input id="score" type="number" class="form-control" name="score" value="{{ old('score') }}"  min="0" required>

                @if ($errors->has('score'))
                    <span class="help-block">
                        <strong>{{ $errors->first('score') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <!--Records input fields-->
        @foreach($records as $record)
            <div class="form-group">
                <label for="records[]" class="col-md-4 control-label">{{$record->acronym}}</label>
                <input id="records[]" name="records[]" type="checkbox" value="{{$record->id}}">
            </div>
        @endforeach



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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
@endsection
