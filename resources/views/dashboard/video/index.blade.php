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
                		<iframe width="220" height="155" src="{{$video->path}}">
        				</iframe> 
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
