@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('competition.create') }}" class="btn btn-success btn-responsive" role="button">Add new Competition</a>
	<table class="table table-bordered table-sm">
	  	<thead>
	    	<tr>
	      		<th>ID</th>
	      		<th>Name</th>
	      		<th>Start Date</th>
	      		<th>Finish Date</th>
	      		<th>Country</th>
	      		<th>City</th>
	      		<th>Venue</th>
	      		<th>Series</th>
	      		<th>Edit</th>
	    	</tr>
	  	</thead>
	  	
	  	<tbody>
	  		@foreach($competitions as $competition)
		    	<tr>
		      		<th scope="row">{{$competition->id}}</th>
		      		<td>{{$competition->name}}</td>
		      		<td>{{$competition->date_start}}</td>
		     		<td>{{$competition->date_finish}}</td>
		      		<td>{{$competition->country}}</td>
		      		<td>{{$competition->city}}</td>
		      		<td>{{$competition->venue}}</td>	
		      		<td>{{$competition->series->name}}</td>	
		      		<td>	
		      			<a href="{{ route('competition.edit',$competition->id)}}" class="btn btn-primary btn-sm">
  							Edit
						</a>
					</td>

		    	</tr>
	    	@endforeach
	  </tbody>
	</table>
@endsection