@extends('layouts.dashboard')

@section('content')
{!! Form::open(array('route' => 'pending.publish','class' => 'form-horizontal'))!!}

   	{{ csrf_field() }}

	<div class="panel panel-default">
		<div class="panel-heading">Athletes Pending</div>
		<div class="panel-body">
			<label>Publish All Athletes</label>
			<input type="checkbox" id="checkAllAthletes">
			<div class="table-responsive">
			<table class="table table-bordered table-sm" style="position:static;">
			  	<thead>
			    	<tr>
			    		<th>Publish</th>
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
				    	<tr>
				    		<td><input class="athletes" name="athletes[]" type="checkbox" value="{{$athlete->id}}"></td>
				      		<th scope="row">{{$athlete->id}}</th>
				      		<td>{{$athlete->first_name}}</td>
				      		<td>{{$athlete->last_name}}</td>
				     		<td>{{$athlete->birth}}</td>
				     		<td>{{$athlete->gender}}</td>
				     		<td>{{optional($athlete->club)->name}}</td>
				      		<td><img src="/storage/{{ $athlete->picture }}" class="img-responsive" style="max-width: 10vw; max-height: 10vh;"></td>
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
	</div>
    <button type="submit" class="btn btn-success" style="margin-bottom: 10px;">Publish</button>

	<div class="panel panel-default">
		<div class="panel-heading">Competitions Pending</div>
		<div class="panel-body">
			<label>Publish All Competitions</label>
			<input type="checkbox" id="checkAllCompetitions">
			<div class="table-responsive">
			<table class="table table-bordered table-sm" style="position:static;">
			  	<thead>
			    	<tr>
			    		<th>Publish</th>
			      		<th>ID</th>
			      		<th>Name</th>
			      		<th>Start Date</th>
			      		<th>Finish Date</th>
			      		<th>Country</th>
			      		<th>City</th>
			      		<th>Venue</th>
			      		<th>Edit</th>
			    	</tr>
			  	</thead>

			  	<tbody>
			  		@foreach($competitions as $competition)
				    	<tr>
				    		<td><input class="competitions" name="competitions[]" type="checkbox" value="{{$competition->id}}"></td>
				      		<th scope="row">{{$competition->id}}</th>
				      		<td>{{$competition->name}}</td>
				      		<td>{{$competition->date_start}}</td>
				     		<td>{{$competition->date_finish}}</td>
				      		<td>{{$competition->country}}</td>
				      		<td>{{$competition->city}}</td>
				      		<td>{{$competition->venue}}</td>
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
	</div>
    <button type="submit" class="btn btn-success" style="margin-bottom: 10px;">Publish</button>
	<div class="panel panel-default">
		<div class="panel-heading">Results Pending</div>
		<div class="panel-body">
			<label>Publish All Results</label>
			<input type="checkbox" id="checkAllResults">
			<div class="table-responsive">
			<table class="table table-bordered table-sm table-responsive" style="position:static;">
			  	<thead>
			    	<tr>
			    		<th>Publish</th>
			      		<th>ID</th>
			      		<th>Position</th>
			      		<th>Athlete</th>
			      		<th>Competition</th>
			      		<th>Race</th>
			      		<th>Date</th>
			      		<th>Event</th>
			      		<th>Mark</th>
			      		<th>Score</th>
			      		<th>Edit</th>
			    	</tr>
			  	</thead>
			  		@foreach($results as $result)
				    	<tr>
				    		<td><input class="results" name="results[]" type="checkbox" value="{{$result->id}}"></td>
				      		<th scope="row">{{$result->id}}</th>
				      		<td>{{$result->position}}</td>
				      		<td>{{$result->athlete->first_name}} {{$result->athlete->last_name}}</td>
				     		<td>{{$result->competition->name}}</td>
				      		<td>{{$result->race}}</td>
				      		<td>{{$result->date}}</td>
				      		<td>{{$result->event->name}}</td>
				      		<td>{{$result->mark}}</td>
				      		<td>{{$result->score}}</td>
				      		<td>
				      			<a href="{{ route('result.edit',$result->id)}}" class="btn btn-primary btn-sm">
		  							Edit
								</a>
							</td>

				    	</tr>
			    	@endforeach
			  	<tbody>

			  </tbody>
			</table>
			</div>
		</div>
	</div>
    <button type="submit" class="btn btn-success" style="margin-bottom: 10px;">Publish</button>

{!! Form::close() !!}

@endsection
@section('scripts')
<script type="text/javascript">
	$("#checkAllAthletes").click(function () {
    	$("input.athletes").not(this).prop('checked', this.checked);
 	});

 	$("#checkAllCompetitions").click(function () {
    	$("input.competitions").not(this).prop('checked', this.checked);
 	});

 	$("#checkAllResults").click(function () {
    	$("input.results").not(this).prop('checked', this.checked);
 	});
</script>
@endsection
