@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Edit Athlete</h4></u></p>

    {!! Form::model($event, ['route' => ['events.update',$event->id],'class'=>'form-horizontal']) !!}

        {{ Form::token() }}
        {{ method_field('PATCH') }}

        <!--Name input field-->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Name</label>
            <div class="col-md-6">
                {{ Form::text('name',null,["class"=> 'form-control'])}}


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

        <!--Order input filed-->
        <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
            <label for="order" class="col-md-4 control-label">Order</label>
            <div class="col-md-6">
                {{ Form::text('order',null,["class"=> 'form-control'])}}
                @if ($errors->has('order'))
                    <span class="help-block">
                        <strong>{{ $errors->first('order') }}</strong>
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