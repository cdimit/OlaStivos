@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('club.create') }}" class="btn btn-success btn-responsive" role="button">Add new Club</a>
	<table class="table table-bordered table-sm">
	  	<thead>
	    	<tr>
	      		<th>ID</th>
	      		<th>Name</th>
	      		<th>Acronym</th>
	      		<th>City</th>
	      		<th>Picture</th>
	      		<th>Since</th>
	      		<th>Edit</th>
	    	</tr>
	  	</thead>
	  	
	  	<tbody>
	  		@foreach($clubs as $club)
		    	<tr>
		      		<th scope="row">{{$club->id}}</th>
		      		<td>{{$club->name}}</td>
		      		<td>{{$club->acronym}}</td>
		     		<td>{{$club->city}}</td>
		      		<td><img src="/storage/{{ $club->picture }}" class="img-responsive" style="max-width: 10vw; max-height: 10vh;"></td>
		      		<td>{{$club->since}}</td>
		      		<td>	
		      			<a href="{{ route('club.edit',$club->id)}}" class="btn btn-primary btn-sm">
  							Edit
						</a>
					</td>

		    	</tr>
	    	@endforeach
	  </tbody>
	</table>
@endsection
