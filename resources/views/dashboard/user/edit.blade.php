@extends('layouts.dashboard')

@section('content')   
    <p><u><h4>Edit User</h4></u></p>

    {!! Form::model($user, ['route' => ['users.update',$user->id],'class'=>'form-horizontal']) !!}

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

        <!--Role input filed-->
        @foreach($roles as $role)
            <div class="form-group">
                <label for="roles[]" class="col-md-4 control-label">{{$role->name}}</label>
                <div class="col-md-6">

                    <div class="form-check">
                        <label class="form-check-label">
                            <input name="roles[]" class="form-check-input" type="checkbox" @if($user->hasRole($role->name)) checked @endif value="{{$role->id}}">
                        </label>
                    </div>

                </div>
            </div>
        @endforeach

        <div class="form-group">
            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{ route('users.index') }}">Cancel</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>
            </div>
        </div>


    {!! Form::close() !!}
@endsection