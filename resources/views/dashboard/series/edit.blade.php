@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Edit Competition Series</h4></u></p>
    {!! Form::model($series, ['route' => ['series.update',$series->id],'class'=>'form-horizontal']) !!}
                    
        {{ Form::token() }}
        {{ method_field('PATCH') }}
        
        <!--Name input form-->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Series Name</label>

            <div class="col-md-6">
                {{ Form::text('name',null,["class"=> 'form-control'])}}
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
  

        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{route('series.index')}}">Cancel</a>
            </div>
            <div class="col-md-2">
                {{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}
            </div>
        </div>


    {!! Form::close() !!}
@endsection