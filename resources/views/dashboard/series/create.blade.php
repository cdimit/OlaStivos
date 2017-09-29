@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Add New Competition Series</h4></u></p>
    {!! Form::open(
        array(
            'route' => 'series.store', 
            'class' => 'form-horizontal')
        ) 
    !!}
    
        {{ csrf_field() }}     

        <!--Name input form-->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Series Name</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

       
        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{ route('series.index') }}">Cancel</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Save Competition Series
                </button>
            </div>
        </div>


    {!! Form::close() !!}
@endsection