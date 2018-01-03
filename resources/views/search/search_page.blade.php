@extends('layouts.app')
@section('styles')

    <link href="{{ asset('/css/headings/heading-in-pages.css') }}" rel="stylesheet">

@endsection
@section('content')
<div id="content" class="container" style="background-color: #F9F9F9;">
    <div class="row">
        <div class="col-md-12">
        	<h1>Σελίδα Πλοήγησης</h1>
        	<h3>Ψάξε αθλητή ή αγώνα:</h3>
        	{!! Form::open(array('route' => 'search.show', 'class'=>'form-inline')) !!}
			    {{ csrf_field() }}
			   	<div class="input-group">
			      	<input name="searchQuery" id="searchInput" class="form-control" type="text" placeholder="Ψάξε αθλητή ή αγώνα..." style="width: 100%;" />

			    </div>
			    <div class="input-group">
	                <select id="type" name="type" class="form-control selectpicker">
	                	<option value="any">Οτιδήποτε</option>
	                    <option value="athletes">Αθλητές</option>
	                   	<option value="competitions">Αγώνες</option>
	                </select>
	            </div>



			    <div class="input-group">

					<button id="searchButton" class="btn btn-default" type="submit">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>

			    </div>
			{!! Form::close() !!}


			<!-- Show Results of Search -->
			<div class="panel panel-default" style="margin-top: 10px;">
				<div class="panel-heading">Αποτελέσματα που βρέθηκαν:</div>
				<div class="panel-body">
					@if(!$athletes->isEmpty())
			        	<h4>Αθλητές:</h4>
			        	<div class="table-responsive">
  							<table class="table table-condensed">
				        		<tbody>
					           		@foreach($athletes as $athlete)
					           			<tr>
					           				<td>
					           					<a href="/athlete/{{$athlete->id}}">{{$athlete->name}}</a>
					           				</td>
					           				<td>({{date('d-m-Y', strtotime($athlete->dob))}})</td>
					           				<td><a href="/club/{{$athlete->club->id}}">{{$athlete->club->acronym}}</a></td>
					           			</tr>
					           		@endforeach
				           		</tbody>
    						</table>
						</div>
		           	@endif
		           	@if(!$competitions->isEmpty())
		           		<h4>Αγώνες:</h4>
			        	<div class="table-responsive">
  							<table class="table table-condensed">
				        		<tbody>
					           		@foreach($competitions as $competition)
					           			<tr>
					           				<td>
					           					<a href="/competition/{{$competition->id}}">{{$competition->name}}</a>
					           				</td>
					           				<td>{{date('d-m-Y', strtotime($competition->date_start))}} εώς {{date('d-m-Y', strtotime($competition->date_finish))}}</td>
					           				<td>{{$competition->city}}, {{$competition->country}}</td>
					           			</tr>
					           		@endforeach
				           		</tbody>
    						</table>
						</div>
		           	@endif

		        </div>
        	</div>
        </div>
    </div>
</div>
@endsection
