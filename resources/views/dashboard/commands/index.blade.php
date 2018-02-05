@extends('layouts.dashboard')

@section('content')
	@if (session('status'))
		<div class="alert alert-success">
			<strong>{{ session('status') }}</strong>
		</div>
	@endif

	<h1>Available Commands:</h1>
	<ul>
		<li><button onclick="location.href='{{ route('commands.fixYearInAthletes') }}'">
     Fix Year In Athletes With DOB</button></li>



		 {!! Form::open(
         array(
             'route' => 'commands.refreshRecordByEvent',
             'class' => 'form-horizontal'
             )
         )
     !!}

     {{ csrf_field() }}

		 <li>
			 <button>
      Refresh Records By Event</button>
			<select  name="event" class="selectpicker" >
							<option value="all">All (Results: {{App\Result::count()}})</option>
					@foreach($events as $event)
							<option value="{{$event->id}}">{{$event->name}} {{$event->season}} {{$event->gender}} (Results: {{$event->results->count()}})</option>
					@endforeach
			</select>
		</li>

			{!! Form::close() !!}

	</ul>



@endsection
