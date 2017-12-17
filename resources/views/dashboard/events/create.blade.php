@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Add New Event</h4></u></p>
    {!! Form::open(
        array(
            'route' => 'events.store',
            'class' => 'form-horizontal')
        )
    !!}

    {{ csrf_field() }}

        <!--Name input field-->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Name</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Season input filed-->
        <div class="form-group{{ $errors->has('season') ? ' has-error' : '' }}">
            <label for="season" class="col-md-4 control-label">Season</label>
            <div class="col-md-6">
                {{ Form::select('season', [ 'outdoor' => 'Outdoor','indoor' => 'Indoor','cross country' => 'Cross Country'] )}}
                @if ($errors->has('season'))
                    <span class="help-block">
                        <strong>{{ $errors->first('season') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Type input filed-->
        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            <label for="type" class="col-md-4 control-label">Type</label>
            <div class="col-md-6">
                {{ Form::select('type', [ 'track' => 'track','field' => 'Field','relay' => 'Relay'] )}}
                @if ($errors->has('type'))
                    <span class="help-block">
                        <strong>{{ $errors->first('type') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Gender input filed-->
        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
            <label for="gender" class="col-md-4 control-label">Gender</label>
            <div class="col-md-6">
                {{ Form::select('gender', [ 'male' => 'Male','female' => 'Female'] )}}
                @if ($errors->has('gender'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{ route('events.index') }}">Cancel</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Save Event
                </button>
            </div>
        </div>


    {!! Form::close() !!}



@endsection
