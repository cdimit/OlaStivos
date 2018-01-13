@extends('layouts.dashboard')

@section('content')

	@if (session('status'))
	<div class="alert alert-success">
	<strong>{{ session('status') }}</strong>
	</div>
	@endif

	<p>
    	<a href="{{ route('competition.create') }}" class="btn btn-success btn-responsive" role="button">Add new Competition</a>
    </p>
    <div style="width:285px;">
		*Competitions still pending are in color:
		<div class="red-square"></div>
	</div>
	<div class="panel panel-default">
    	<div class="panel-heading">
    		Search Competition to edit :
    		<select  class="selectpicker" data-live-search="true" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<option data-tokens="" value=""></option>
		      	@foreach($competitions as $competition)
		            <option data-tokens="{{$competition->name}} {{$competition->date_start}}" value="{{route('competition.edit',$competition->id)}}">{{$competition->name}} {{$competition->date_start}}</option>
		        @endforeach
		    </select>
    	</div>
		<div class="panel-body">
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
			  		@foreach($competitions->sortByDesc('id') as $competition)
				    	<tr @if($competition->isPending()) bgcolor="#ffd6cc" @endif>
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
		</div>
	</div>
@endsection
