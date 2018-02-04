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
     Fix Year In Athletes With DOB</button></td></li>
	</ul>	
@endsection
