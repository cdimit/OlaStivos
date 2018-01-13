@extends('layouts.dashboard')

@section('content')

	@if (session('status'))
	<div class="alert alert-success">
	<strong>{{ session('status') }}</strong>
	</div>
	@endif

	<p>
    	<a href="{{ route('events.create') }}" class="btn btn-success btn-responsive" role="button">Add new Event</a>
    </p>

    <!-- OUTDOOR EVENTS -->
    <div class="panel panel-default" >
    	<div class="panel-heading">
    		<b>Outdoor Events</b> - Search an outdoor event:
    		<select  class="selectpicker" data-live-search="true" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
    		    <option data-tokens="" value=""></option>
                @foreach($outdoorEvents as $event)
                    <option data-tokens="{{$event->name}} {{$event->gender}}" value="{{route('events.edit',$event->id)}}">{{$event->name}} {{$event->gender}}</option>
                @endforeach
            </select>
    	</div>
		<div class="panel-body" style="overflow-y: scroll; height: 250px">
			<table class="table table-bordered table-sm" style="position:static;">
			  	<thead>
			    	<tr>
			      		<th>ID</th>
			      		<th>Event</th>
			      		<th>Type</th>
			      		<th>Season</th>
			      		<th>Gender</th>
			      		<th>Edit</th>

			    	</tr>
			  	</thead>

			  	<tbody>
			  		@foreach($outdoorEvents as $event)
				    	<tr>
				      		<th scope="row">{{$event->id}}</th>
				      		<td>{{$event->name}}</td>
				      		<td>{{$event->type}}</td>
				     		<td>{{$event->season}}</td>
				     		<td>{{$event->gender}}</td>
				      		<td>
				      			<a href="{{ route('events.edit',$event->id)}}" class="btn btn-primary btn-sm">
		  							Edit
								</a>
							</td>

				    	</tr>
			    	@endforeach
			  </tbody>
			</table>

		</div>
	</div>

	<!-- OUTDOOR EVENTS -->
    <div class="panel panel-default">
    	<div class="panel-heading">
    		<b>Indoor Events</b> - Search an indoor event:
    		<select  class="selectpicker" data-live-search="true" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
    			<option data-tokens="" value=""></option>
                @foreach($indoorEvents as $event)
                    <option data-tokens="{{$event->name}} {{$event->gender}}" value="{{route('events.edit',$event->id)}}">{{$event->name}} {{$event->gender}}</option>
                @endforeach
            </select>
    	</div>
		<div class="panel-body" style="overflow-y: scroll; height: 250px">
			<table class="table table-bordered table-sm" style="position:static;">
			  	<thead>
			    	<tr>
			      		<th>ID</th>
			      		<th>Event</th>
			      		<th>Type</th>
			      		<th>Season</th>
			      		<th>Gender</th>
			      		<th>Edit</th>

			    	</tr>
			  	</thead>

			  	<tbody>
			  		@foreach($indoorEvents as $event)
				    	<tr>
				      		<th scope="row">{{$event->id}}</th>
				      		<td>{{$event->name}}</td>
				      		<td>{{$event->type}}</td>
				     		<td>{{$event->season}}</td>
				     		<td>{{$event->gender}}</td>
				      		<td>
				      			<a href="{{ route('events.edit',$event->id)}}" class="btn btn-primary btn-sm">
		  							Edit
								</a>
							</td>


				    	</tr>
			    	@endforeach
			  </tbody>
			</table>

		</div>
	</div>

	<!-- OUTDOOR EVENTS -->
    <div class="panel panel-default">
    	<div class="panel-heading">
    		<b>Cross Country Events</b> - Search a XC event:
    		<select  class="selectpicker" data-live-search="true" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
    		    <option data-tokens="" value=""></option>
                @foreach($ccEvents as $event)
                    <option data-tokens="{{$event->name}} {{$event->gender}}" value="{{route('events.edit',$event->id)}}">{{$event->name}} {{$event->gender}}</option>
                @endforeach
            </select>
    	</div>
		<div class="panel-body" style="overflow-y: scroll; height: 250px">
			<table class="table table-bordered table-sm" style="position:static;">
			  	<thead>
			    	<tr>
			      		<th>ID</th>
			      		<th>Event</th>
			      		<th>Type</th>
			      		<th>Season</th>
			      		<th>Gender</th>
			      		<th>Edit</th>

			    	</tr>
			  	</thead>

			  	<tbody>
			  		@foreach($ccEvents as $event)
				    	<tr>
				      		<th scope="row">{{$event->id}}</th>
				      		<td>{{$event->name}}</td>
				      		<td>{{$event->type}}</td>
				     		<td>{{$event->season}}</td>
				     		<td>{{$event->gender}}</td>
				      		<td>
				      			<a href="{{ route('events.edit',$event->id)}}" class="btn btn-primary btn-sm">
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
