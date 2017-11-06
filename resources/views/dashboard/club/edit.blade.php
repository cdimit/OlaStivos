@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Edit Club</h4></u></p>
    {!! Form::model($club, ['route' => ['club.update',$club->id],'files' => true,'class'=>'form-horizontal']) !!}

        {{ Form::token() }}
        {{ method_field('PATCH') }}

        <!--Name input form-->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Club Name</label>

            <div class="col-md-6">
                {{ Form::text('name',null,["class"=> 'form-control'])}}
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <!--Acronym input form-->
        <div class="form-group{{ $errors->has('acronym') ? ' has-error' : '' }}">
            <label for="accronym" class="col-md-4 control-label">Club Acronym</label>
            <div class="col-md-6">
                {{ Form::text('acronym',null,["class"=> 'form-control'])}}

                @if ($errors->has('acronym'))
                    <span class="help-block">
                        <strong>{{ $errors->first('acronym') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--City input form-->
        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">City</label>
            <div class="col-md-6">
                {{ Form::text('city',null,["class"=> 'form-control'])}}

                @if ($errors->has('city'))
                    <span class="help-block">
                        <strong>{{ $errors->first('city') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Date input form-->
        <div class="form-group{{ $errors->has('since') ? ' has-error' : '' }}">
            <label for="since" class="col-md-4 control-label">Foundation Year</label>
            <div class="col-md-6">
                {{ Form::number('since',null,["class"=> 'form-control',"step"=>1 ,"min"=>1800])}}
                @if ($errors->has('since'))
                    <span class="help-block">
                        <strong>{{ $errors->first('since') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="picture" class="col-md-4 control-label">Club Image</label>
            <div class="col-md-6">
                {!! Form::file('picture', null) !!}
            </div>
        </div>


        @include('links.edit', ['var' => $club])



        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{route('club.index')}}">Cancel</a>
            </div>
            <div class="col-md-2">
                {{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}
            </div>
        </div>


    {!! Form::close() !!}
@endsection
