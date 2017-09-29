@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('series.create') }}" class="btn btn-success btn-responsive" role="button">Add new Competition Series</a>
	<table class="table table-bordered table-sm">
	  	<thead>
	    	<tr>
	      		<th>ID</th>
	      		<th>Name</th>
	      		<th>Edit</th>
	    	</tr>
	  	</thead>
	  	
	  	<tbody>
	  		@foreach($series as $serie)
		    	<tr>
		      		<th scope="row">{{$serie->id}}</th>
		      		<td>{{$serie->name}}</td>
		      		<td>	
		      			<a href="{{ route('series.edit',$serie->id)}}" class="btn btn-primary btn-sm">
  							Edit
						</a>
					</td>

		    	</tr>
	    	@endforeach
	  </tbody>
	</table>
@endsection
