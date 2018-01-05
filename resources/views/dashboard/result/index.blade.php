@extends('layouts.dashboard')

@section('content')
	<p>
    	<a href="{{ route('result.create') }}" class="btn btn-success btn-responsive" role="button">Add new Result</a>
    	<a href="{{ route('result.createRace') }}" class="btn btn-info btn-responsive" role="button">Add new Race</a>
	</p>
	<div style="width:265px;">
		*Results still pending are in color:
		<div class="red-square"></div>
	</div>

	<table class="table table-bordered table-sm" style="position:static;">
	  	<thead>
	    	<tr>
	      		<th>ID</th>
	      		<th>Position</th>
	      		<th>Athlete</th>
	      		<th>Competition</th>
	      		<th>Race</th>
	      		<th>Date</th>
	      		<th>Event</th>
	      		<th>Mark</th>
	      		<th>Score</th>
	      		<th>Option</th>
	    	</tr>
	  	</thead>
	  		@foreach($results->sortByDesc('id') as $result)
		    	<tr @if($result->isPending()) bgcolor="#ffd6cc" @endif>
		      		<th scope="row">{{$result->id}}</th>
		      		<td>{{$result->position}}</td>
		      		<td>{{$result->athlete->first_name}} {{$result->athlete->last_name}}</td>
		     		<td>{{$result->competition->name}}</td>
		      		<td>{{$result->race}}</td>
		      		<td>{{$result->date}}</td>
		      		<td>{{$result->event->name}}</td>
		      		<td>{{$result->markstr}}</td>
		      		<td>{{$result->score}}</td>
		      		<td>
		      			<a href="{{ route('result.edit',$result->id)}}" class="btn btn-primary btn-sm">
  							Edit
						</a>
						@if (Auth::user()->can('delete', Result::class))
							{{ Form::open(['route' => ['result.destroy', $result->id], 'method' => 'delete']) }}
								{{ Form::submit('Remove') }}
							{{ Form::close() }}
						@endif
					</td>

		    	</tr>
	    	@endforeach
	  	<tbody>

	  </tbody>
	</table>
@endsection
