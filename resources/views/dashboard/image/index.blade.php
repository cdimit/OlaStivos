@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('image.create') }}" class="btn btn-success btn-responsive" role="button">Add new Image</a>
	<table class="table table-bordered table-sm">
	  	<thead>
	    	<tr>
	      		<th>ID</th>
	      		<th>Image</th>
	      		<th>Name</th>
	      		<th>Athletes No</th>
	      		<th>Clubs No</th>
	      		<th>Competitions No</th>
	      		<th>Edit</th>
	    	</tr>
	  	</thead>

	  	<tbody>
	  		@foreach($images as $image)
		    	<tr>
		      		<th scope="row">{{$image->id}}</th>
		      		<td><img src="/storage/{{ $image->path }}" class="img-responsive" style="max-width: 10vw; max-height: 10vh;"></td>
		      		<td>{{$image->name}}</td>
		     		<td>{{$image->athletes->count()}}</td>
		      		<td>{{$image->clubs->count()}}</td>
		      		<td>{{$image->competitions->count()}}</td>
		      		<td>
		      			<a href="{{ route('image.edit',$image->id)}}" class="btn btn-primary btn-sm">
  							Edit
						</a>
					</td>

		    	</tr>
	    	@endforeach
	  </tbody>
	</table>
@endsection
