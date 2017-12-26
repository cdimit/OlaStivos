{!! Form::open(array('route' => 'search.show', 'class'=>'form navbar-form navbar-right searchform')) !!}
    {{ csrf_field() }}
	<div class="search-wrapper">
	    <div id="input" class="input-group input-group-sm"  style="position: relative; margin-top:10px; display: inline-block;">
	      <input name="searchQuery" id="searchInput" class="form-control" type="text" placeholder="Ψάξε αθλητή ή αγώνα..." style="width: 80%;" />
	      <span class="input-group-btn">
			<button id="searchButton" class="btn btn-default" type="submit">
				<i class="fa fa-search" aria-hidden="true"></i>
			</button>
	      </span>
	      <div id="searchPanel" class="panel" style="position: absolute; left: 0; width: 100%; z-index:10;" >
{{-- 	        <ul id='resultsSearch' class="list-unstyled">
	        </ul> --}}

			<h5 style="margin-bottom:0; margin-top:0;">Αθλητές:</h5>
	       	<ul id='resultsSearchAthletes' class="list-unstyled">
	        </ul>
	        <h5 style="margin-bottom:0; margin-top:0;">Αγώνες:</h5>
	        <ul id='resultsSearchCompetitions' class="list-unstyled">
	        </ul>



	      </div>

	    </div>
	</div>
{!! Form::close() !!}