@extends('layouts.dashboard')

@section('content')
	<p>
    	<a href="{{ route('athlete.create') }}" class="btn btn-success btn-responsive" role="button">Add new Athlete</a>
    </p>
    <div style="width:265px;">
		*Athletes still pending are in color: 
		<div class="red-square"></div>
	</div>

    <div class="panel panel-default">
    	<div class="panel-heading">
    		Search Athlete to edit : 
    		<select  class="selectpicker" data-live-search="true" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<option data-tokens="" value=""></option>
		      	@foreach($athletes as $athlete)
		            <option data-tokens="{{$athlete->name}} {{$athlete->dob}}" value="{{route('athlete.edit',$athlete->id)}}">{{$athlete->name}} {{$athlete->dob}}</option>
		        @endforeach
		    </select>
    	</div>
		<div class="panel-body">
			<table class="table table-bordered table-sm" style="position:static;">
			  	<thead>
			    	<tr>
			      		<th>ID</th>
			      		<th>First Name</th>
			      		<th>Last Name</th>
			      		<th>Date of Birth</th>
			      		<th>Gender</th>
			      		<th>Club</th>
			      		<th>Picture</th>
			      		<th>Edit</th>
			    	</tr>
			  	</thead>
			  	
			  	<tbody>
			  		@foreach($athletes as $athlete)
				    	<tr @if($athlete->isPending()) bgcolor="#ffd6cc" @endif>
				      		<th scope="row">{{$athlete->id}}</th>
				      		<td>{{$athlete->first_name}}</td>
				      		<td>{{$athlete->last_name}}</td>
				     		<td>{{$athlete->dob}}</td>
				     		<td>{{$athlete->gender}}</td>
				     		<td>{{$athlete->club->name}}</td>
				      		<td><img src="{{ $athlete->picture }}" class="img-responsive" style="max-width: 8vw; max-height: 8vh;"></td>
				      		<td>	
				      			<a href="{{ route('athlete.edit',$athlete->id)}}" class="btn btn-primary btn-sm">
		  							Edit
								</a>
							</td>

				    	</tr>
			    	@endforeach
			  </tbody>
			</table>
		</div>
	</div>
@endsection
