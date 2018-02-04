@extends('layouts.dashboard')

@section('content')
    <p><u><h4>Add New Athlete</h4></u></p>
    {!! Form::open(
        array(
            'route' => 'athlete.store',
            'class' => 'form-horizontal',
            'files' => true)
        )
    !!}

    {{ csrf_field() }}

        <!--First Name input field-->
        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
            <label for="first_name" class="col-md-4 control-label">First Name</label>
            <div class="col-md-6">
                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

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
                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group">
            <label for="udob" class="col-md-4 control-label">Unknown DOB?</label>
            <div class="col-md-6">
              <input type="checkbox" id="udob" name="udob">

            </div>
        </div>

        <div id="dobDiv">
            <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                <label for="dob" class="col-md-4 control-label">Date of Birth</label>
                <div class="col-md-6">
                    {{Form::date('dob', \Carbon\Carbon::now())}}

                    @if ($errors->has('dob'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dob') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div> 
        <!--Year input field-->
        <div id="udobDiv" name="udobDiv">
            <div id="year" class="form-group{{ $errors->has('year') ? ' has-error' : '' }} year">
                <label id="year" for="year" class="col-md-4 control-label">Year of Birth</label>
                <div class="col-md-6">
                  <input id="year" type="text" class="form-control" name="year" value="{{ old('year') }}" >

                    @if ($errors->has('year'))
                        <span class="help-block">
                            <strong>{{ $errors->first('year') }}</strong>
                        </span>
                    @endif
                </div>
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
    
        <div class="form-group">
            <label for="picture" class="col-md-4 control-label">Add Athlete Links:</label>
            @include('links.create')
        </div>

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
    {{-- links Script --}}
    <script type="text/javascript" src="/js/links/add_links.js"></script>
    {{-- dob or year input script --}}
    <script type="text/javascript">

        $(document).ready(function () {
            birthdayInput();
            // $('#udobDiv').hide();
            $('#udob').on('change',function(){
                birthdayInput();
            });

            function birthdayInput() {
                if(document.getElementById("udob").checked === true){
                    $('#udobDiv').show();
                    $('#dobDiv').hide();
                }else{
                    $('#udobDiv').hide();
                    $('#dobDiv').show();
                }
                
            };
        });

    </script>
@endsection