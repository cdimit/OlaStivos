@extends('layouts.dashboard')

@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
@endsection

@section('content')
    <p><u><h4>Add New Image</h4></u></p>
    {!! Form::open(
        array(
            'route' => 'image.store',
            'class' => 'form-horizontal',
            'files' => true)
        )
    !!}

        {{ csrf_field() }}


        <div class="form-group">
            <label for="picture" class="col-md-4 control-label">Image</label>
            <div class="col-md-6">
                {!! Form::file('picture', null) !!}
            </div>
        </div>

        <!--Name input form-->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Image Name</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Athlete input field-->
        <div class="form-group{{ $errors->has('athlete_id') ? ' has-error' : '' }}">
            <label for="athlete_id" class="col-md-4 control-label">Athletes</label>
            <div class="col-md-6">
                <select  id="athlete_id" name="athlete_id[]" class="selectpicker" data-show-subtext="true" data-live-search="true" multiple>
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

        <!--Competition input field-->
        <div class="form-group{{ $errors->has('competition_id') ? ' has-error' : '' }}">
            <label for="competition_id" class="col-md-4 control-label">Competitions</label>
            <div class="col-md-6">
                <select  id="competition_id" name="competition_id[]" class="selectpicker" data-show-subtext="true" data-live-search="true" multiple>
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

        <!--Competition input field-->
        <div class="form-group{{ $errors->has('club_id') ? ' has-error' : '' }}">
            <label for="competition_id" class="col-md-4 control-label">Clubs</label>
            <div class="col-md-6">
                <select  id="club_id" name="club_id[]" class="selectpicker" data-show-subtext="true" data-live-search="true" multiple>
                    @foreach($clubs as $club)
                        <option value="{{$club->id}}">{{$club->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('club_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('club_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{ route('image.index') }}">Cancel</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Save Image
                </button>
            </div>
        </div>


    {!! Form::close() !!}
@endsection
