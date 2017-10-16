@extends('layouts.dashboard')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
@endsection


@section('content')

    <p><u><h4>Edit Result</h4></u></p>
    {!! Form::model($result, ['route' => ['result.update',$result->id],'class'=>'form-horizontal']) !!}
                    
        {{ Form::token() }}
        {{ method_field('PATCH') }}   

        <!--Position input field-->
        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
            <label for="position" class="col-md-4 control-label">Position</label>
            <div class="col-md-6">
                {{ Form::text('position',null,["class"=> 'form-control'])}}

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
                        <option @if($athlete->id ==$result->athlete->id) selected @endif value="{{$athlete->id}}">{{$athlete->first_name}} {{$athlete->last_name}} {{$athlete->dob}}</option>
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
                        <option @if($event->id ==$result->event->id) selected @endif value="{{$event->id}}">{{$event->name}} {{$event->season}} {{$event->gender}}</option>
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
                {{ Form::text('mark',null,["class"=> 'form-control'])}}

                @if ($errors->has('mark'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mark') }}</strong>
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
                        <option @if($competition->id ==$result->competition->id) selected @endif value="{{$competition->id}}">{{$competition->name}} {{$competition->date_start}}</option>
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
                {{ Form::text('race',null,["class"=> 'form-control','required'])}}

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
                {{ Form::text('score',null,["class"=> 'form-control'])}}
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
                <input id="records[]" name="records[]" type="checkbox" value="{{$record->id}}" @if($achievements->contains($record->id)) checked @endif>
            </div>
        @endforeach
        

                        
        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{route('result.index')}}">Cancel</a>
            </div>
            <div class="col-md-2">
                {{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}
            </div>
        </div>


    {!! Form::close() !!}
@endsection
@section('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
@endsection