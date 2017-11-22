@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Add New Competition</h4></u></p>
    {!! Form::open(
        array(
            'route' => 'competition.store',
            'class' => 'form-horizontal',
            'files' => true)
        )
    !!}

    {{ csrf_field() }}

        <!--Name input field-->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Competition Name</label>
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
            <label for="picture" class="col-md-4 control-label">Competition Image</label>
            <div class="col-md-6">
                {!! Form::file('picture', null) !!}
            </div>
        </div>

        <!--Start Date input field-->
        <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
            <label for="date_start" class="col-md-4 control-label">Start Date</label>
            <div class="col-md-6">
                {{Form::date('date_start', \Carbon\Carbon::now())}}

                @if ($errors->has('date_start'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date_start') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Finish Date input field-->
        <div class="form-group{{ $errors->has('date_finish') ? ' has-error' : '' }}">
            <label for="date_finish" class="col-md-4 control-label">Finish Date</label>
            <div class="col-md-6">
                {{Form::date('date_finish', \Carbon\Carbon::now())}}

                @if ($errors->has('date_finish'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date_finish') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Country input field-->
        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
            <label for="country" class="col-md-4 control-label">Country</label>
            <div class="col-md-6">
                <input id="country" type="text" class="form-control" name="country" value="{{ old('country') }}" required autofocus>

                @if ($errors->has('country'))
                    <span class="help-block">
                        <strong>{{ $errors->first('country') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--City input field-->
        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
            <label for="city" class="col-md-4 control-label">City</label>
            <div class="col-md-6">
                <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}" required autofocus>

                @if ($errors->has('city'))
                    <span class="help-block">
                        <strong>{{ $errors->first('city') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Venue input field-->
        <div class="form-group{{ $errors->has('venue') ? ' has-error' : '' }}">
            <label for="venue" class="col-md-4 control-label">Venue</label>
            <div class="col-md-6">
                <input id="venue" type="text" class="form-control" name="venue" value="{{ old('venue') }}" required autofocus>

                @if ($errors->has('venue'))
                    <span class="help-block">
                        <strong>{{ $errors->first('venue') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Series input field-->
        <div class="form-group{{ $errors->has('competition_series_id') ? ' has-error' : '' }}">
            <label for="competition_series_id" class="col-md-4 control-label">Competition Series</label>
            <div class="col-md-6">
                {{ Form::select('competition_series_id', $series, null) }}

                @if ($errors->has('competition_series_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('competition_series_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        @include('links.create')


        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{ route('competition.index') }}">Cancel</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Save Competition
                </button>
            </div>
        </div>


    {!! Form::close() !!}
@endsection
