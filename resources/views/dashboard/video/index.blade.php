@extends('layouts.dashboard')

@section('content')
    <a href="{{ route('video.create') }}" class="btn btn-success btn-responsive" role="button">Add new Video</a>
	<table class="table table-bordered table-sm">
	  	<thead>
	    	<tr>
	      		<th>ID</th>
	      		<th>Video</th>
	      		<th>Name</th>
	      		<th>Athletes No</th>
	      		<th>Clubs No</th>
	      		<th>Competitions No</th>
	      		<th>Edit</th>
	    	</tr>
	  	</thead>

	  	<tbody>
	  		@foreach($videos as $video)
		    	<tr>
		      		<th scope="row">{{$video->id}}</th>
		      		<td>
                <video width="400" controls>
                  <source src="/storage/{{$video->path}}" type="video/mp4">
                  Your browser does not support HTML5 video.
                </video>
              </td>
		      		<td>{{$video->name}}</td>
		     		  <td>{{$video->athletes->count()}}</td>
		      		<td>{{$video->clubs->count()}}</td>
		      		<td>{{$video->competitions->count()}}</td>
		      		<td>
		      			<a href="{{ route('video.edit',$video->id)}}" class="btn btn-primary btn-sm">
  							Edit
						</a>
					</td>

		    	</tr>
	    	@endforeach
	  </tbody>
	</table>
@endsection
