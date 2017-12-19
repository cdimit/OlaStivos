@extends('layouts.dashboard')

@section('content')

	<table class="table table-bordered table-sm" style="position:static;">
	  	<thead>
	    	<tr>
	      		<th>ID</th>
	      		<th>Name</th>
	     	    <th>Role</th>
	      		<th>Edit</th>
	      		<th>Delete</th>
	    	</tr>
	  	</thead>
	  	
	  	<tbody>
	  		@foreach($users as $user)
		    	<tr>
		      		<th scope="row">{{$user->id}}</th>
		      		<td>{{$user->name}}</td>
		      		<td>@if($user->hasRole('admin'))<b>Admin</b> @elseif($user->hasRole('moderator')) Moderator @else User @endif</td>
		      		<td>	
		      			<a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary btn-sm">
  							Edit
						</a>
					</td>
					<td>
						<form action="{{ route('users.destroy',$user->id)}}" method="POST">
    						{{ csrf_field() }}
    						{{ method_field('DELETE') }}
    						<button class="btn btn-sm btn-danger">Delete</button>
						</form>
					</td>

		    	</tr>
	    	@endforeach
	  </tbody>
	</table>
@endsection
