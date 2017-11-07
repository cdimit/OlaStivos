@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Edit Athlete</h4></u></p>

    {!! Form::model($athlete, ['route' => ['athlete.update',$athlete->id],'files' => true,'class'=>'form-horizontal']) !!}

        {{ Form::token() }}
        {{ method_field('PATCH') }}

        <!--First Name input field-->
        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
            <label for="first_name" class="col-md-4 control-label">First Name</label>
            <div class="col-md-6">
                {{ Form::text('first_name',null,["class"=> 'form-control'])}}

                @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <!--Last Name input field-->
        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
            <label for="last_name" class="col-md-4 control-label">Last Name</label>
            <div class="col-md-6">
                {{ Form::text('last_name',null,["class"=> 'form-control'])}}

                @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Acronym input field-->
        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
            <label for="dob" class="col-md-4 control-label">Date of Birth</label>
            <div class="col-md-6">
                {{Form::date('dob', null)}}

                @if ($errors->has('dob'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dob') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Club input field-->
        <div class="form-group{{ $errors->has('club_id') ? ' has-error' : '' }}">
            <label for="club_id" class="col-md-4 control-label">Club</label>
            <div class="col-md-6">
            {{ Form::select('club_id', $clubs, null) }}

                @if ($errors->has('club_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('club_id') }}</strong>
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
            <label for="picture" class="col-md-4 control-label">Athlete Image</label>
            <div class="col-md-6">
                {!! Form::file('picture', null) !!}
            </div>
        </div>

        @include('links.edit', ['var' => $athlete])

        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{ route('athlete.index') }}">Cancel</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Save Athlete
                </button>
            </div>
        </div>


    {!! Form::close() !!}
@endsection

@section('scripts')
  <script>
  $(document).ready(function() {
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
            $(wrapper).append('<div><input type="text" name="link_name[]"><input type="text" name="link_path[]"><a href="#" class="remove_field">Remove</a></div>'); //add input box
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove();
    })
  });
  </script>
@endsection
