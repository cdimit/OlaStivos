@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Add New Club</h4></u></p>
    {!! Form::open(
        array(
            'route' => 'club.store',
            'class' => 'form-horizontal',
            'files' => true)
        )
    !!}

        {{ csrf_field() }}

        <!--Name input form-->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Club Name</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

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
                <input id="acronym" type="text" class="form-control" name="acronym" value="{{ old('acronym') }}" required>

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
                <input id="acronym" type="text" class="form-control" name="city" value="{{ old('city') }}" required>

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
                <input id="since" type="number" class="form-control" name="since" step="1" min="1800">
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


        @include('links.create')


        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{ route('club.index') }}">Cancel</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Save Club
                </button>
            </div>
        </div>


    {!! Form::close() !!}
@endsection
