@extends('layouts.dashboard')

@section('content')
	<h1>Dashboard Home</h1>

	<div class="panel panel-default">
  	<div class="panel-body">Athletes: {{App\Athlete::all()->count()}}</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">Results: {{App\Result::all()->count()}}</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">Competitions: {{App\Competition::all()->count()}}</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">Series: {{App\CompetitionSeries::all()->count()}}</div>
	</div>
@endsection
