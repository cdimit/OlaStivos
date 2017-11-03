@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('result.create') }}" class="btn btn-success btn-responsive" role="button">Add new Result</a>
    <a href="{{ route('result.createRace') }}" class="btn btn-info btn-responsive" role="button">Add new Race</a>
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
	      		<th>Edit</th>
	    	</tr>
	  	</thead>
	  		@foreach($results as $result)
		    	<tr>
		      		<th scope="row">{{$result->id}}</th>
		      		<td>{{$result->position}}</td>
		      		<td>{{$result->athlete->first_name}} {{$result->athlete->last_name}}</td>
		     		<td>{{$result->competition->name}}</td>
		      		<td>{{$result->race}}</td>
		      		<td>{{$result->date}}</td>
		      		<td>{{$result->event->name}}</td>	
		      		<td>{{$result->mark}}</td>	
		      		<td>{{$result->score}}</td>
		      		<td>	
		      			<a href="{{ route('result.edit',$result->id)}}" class="btn btn-primary btn-sm">
  							Edit
						</a>
					</td>

		    	</tr>
	    	@endforeach
	  	<tbody>

	  </tbody>
	</table>
@endsection
