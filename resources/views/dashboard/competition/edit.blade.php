@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Edit Competition</h4></u></p>

    {!! Form::model($competition, ['route' => ['competition.update',$competition->id],'class'=>'form-horizontal','files'=>true]) !!}

        {{ Form::token() }}
        {{ method_field('PATCH') }}

        <!--Name input field-->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Competition Name</label>
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
            <label for="picture" class="col-md-4 control-label">Competition Image</label>
            <div class="col-md-6">
              <img src="{{ $competition->picture }}" class="img-responsive" style="max-width: 10vw; max-height: 10vh;">
                {!! Form::file('picture', null) !!}
            </div>
        </div>

        <!--Start Date input field-->
        <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
            <label for="date_start" class="col-md-4 control-label">Start Date</label>
            <div class="col-md-6">
                {{Form::date('date_start', null)}}

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
                {{Form::date('date_finish', null)}}

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
                {{ Form::text('country',null,["class"=> 'form-control'])}}

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
                {{ Form::text('city',null,["class"=> 'form-control'])}}

                @if ($errors->has('city'))
                    <span class="help-block">
                        <strong>{{ $errors->first('city') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Venue input field-->
        <div class="form-group{{ $errors->has('venue') ? ' has-error' : '' }}">
            <label for="venue" class="col-md-4 control-label">Venue (nullable)</label>
            <div class="col-md-6">
                {{ Form::text('venue',null,["class"=> 'form-control'])}}

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

        <!--Competition_series input field-->
        <div class="form-group{{ $errors->has('competition_series') ? ' has-error' : '' }}" id="competition_series">
            <label for="competition_series" class="col-md-4 control-label">Relay Athletes</label>
            <div class="col-md-6">
                <select  id="competition_series" name="competition_series[]" class="selectpicker" data-show-subtext="true" data-live-search="true" data-max-options="10" multiple>
                    @foreach($competition->competition_series as $comp_series)
                        <option selected value="{{$comp_series->id}}">{{$comp_series->name}}</option>
                    @endforeach
                    @foreach($competition_series->diff($competition->competition_series) as $comp_series)
                        <option value="{{$comp_series->id}}">{{$comp_series->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('competition_series'))
                    <span class="help-block">
                        <strong>{{ $errors->first('competition_series') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        @include('links.edit', ['var' => $competition])


         <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{route('competition.index')}}">Cancel</a>
            </div>
            <div class="col-md-2">
                {{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}
            </div>
        </div>


    {!! Form::close() !!}
@endsection
