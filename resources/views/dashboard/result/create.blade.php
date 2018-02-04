@extends('layouts.dashboard')

@section('content')

    <p><u><h4>Add New Result</h4></u></p>
    {!! Form::open(
        array(
            'route' => 'result.store',
            'class' => 'form-horizontal'
            )
        )
    !!}

    {{ csrf_field() }}



        <!--Competition input field-->
        <div class="form-group{{ $errors->has('competition_id') ? ' has-error' : '' }}">
            <label for="competition_id" class="col-md-4 control-label">Competition</label>
            <div class="col-md-6">
                <select  id="competition_id" name="competition_id" class="selectpicker" data-show-subtext="true" data-live-search="true">
                    @foreach($competitions->sortByDesc('id') as $competition)
                        <option value="{{$competition->id}}">{{$competition->name}} {{$competition->date_start}}</option>
                    @endforeach
                </select>
                @if ($errors->has('competition_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('competition_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--date input field-->
        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            <label for="date" class="col-md-4 control-label">Date</label>
            <div class="col-md-6">
                {{-- {{Form::date('date', \Carbon\Carbon::now())}} --}}
                <select  id="date" name="date" >

                </select>

                @if ($errors->has('date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Event Type input field-->
        <div class="form-group">
            <label for="event_id" class="col-md-4 control-label">Event Type</label>
            <div class="col-md-6">
                <select  id="type" name="type" class="selectpicker" >
                    @foreach($events->pluck('type')->unique() as $type)
                        <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                </select>
                @if ($errors->has('event_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <!--Event input field-->
        <div class="form-group{{ $errors->has('event_id') ? ' has-error' : '' }}">
            <label for="event_id" class="col-md-4 control-label">Event</label>
            <div class="col-md-6">
                <select  id="event_id" name="event_id" >
                    @foreach($events as $event)
                        <option value="{{$event->id}}">{{$event->name}} {{$event->season}} {{$event->gender}}</option>
                    @endforeach
                </select>
                @if ($errors->has('event_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Athlete input field-->
        <div class="form-group{{ $errors->has('athlete_id') ? ' has-error' : '' }}">
            <label id="athlete_label" for="athlete_id" class="col-md-4 control-label">Athlete</label>
            <div class="col-md-6">
                <select  id="athlete_id" name="athlete_id" class="selectpicker" data-show-subtext="true" data-live-search="true">
                    @foreach($athletes as $athlete)
                        <option value="{{$athlete->id}}">{{$athlete->first_name}} {{$athlete->last_name}} {{$athlete->dob}}</option>
                    @endforeach
                </select>
                @if ($errors->has('athlete_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('athlete_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Relay Athletes input field-->
        <div class="form-group{{ $errors->has('relay_id') ? ' has-error' : '' }}" id="relay_id">
            <label for="relay_id" class="col-md-4 control-label">Relay Athletes</label>
            <div class="col-md-6">
                <select  id="relay_id" name="relay_id[]" class="selectpicker" data-show-subtext="true" data-live-search="true" data-max-options="4" multiple>
                    @foreach($athletes as $athlete)
                        <option value="{{$athlete->id}}">{{$athlete->first_name}} {{$athlete->last_name}} {{$athlete->dob}}</option>
                    @endforeach
                </select>
                @if ($errors->has('relay_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('relay_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Race input field-->
        <div class="form-group{{ $errors->has('race') ? ' has-error ' : '' }}">
            <label for="race" class="col-md-4 control-label">Race</label>
            <div class="col-md-6">
                {{ Form::text('race',null,["class"=> 'form-control','placeholder'=>'Heat, Semi-final...','required'])}}

                @if ($errors->has('race'))
                    <span class="help-block">
                        <strong>{{ $errors->first('race') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <!--Position input field-->
        <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
            <label for="position" class="col-md-4 control-label">Position</label>
            <div class="col-md-6">
                <input id="position" type="text" class="form-control" name="position" value="{{ old('position') }}" required>

                @if ($errors->has('position'))
                    <span class="help-block">
                        <strong>{{ $errors->first('position') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Overall Position input field-->
        <div class="form-group{{ $errors->has('overall') ? ' has-error' : '' }}">
            <label for="overall" class="col-md-4 control-label">Overall</label>
            <div class="col-md-6">
                <input id="overall" type="text" class="form-control" name="overall" value="{{ old('overall') }}" >

                @if ($errors->has('overall'))
                    <span class="help-block">
                        <strong>{{ $errors->first('overall') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Field-Mark input field-->
        <div id="field_mark">
          <div class="form-group{{ $errors->has('meters') ? ' has-error' : '' }}">
            <div class="form-group{{ $errors->has('cmeters') ? ' has-error' : '' }}">
              <label class="col-md-4 control-label">Mark</label>
                <div class="col-md-6" display="inline-block">
                  <div class="col-md-6">

                    <input id="meters" type="number" class="form-control" name="meters" value="{{ old('meters') }}"  step="1" min="0" placeholder="m">
                    @if ($errors->has('meters'))
                        <span class="help-block">
                            <strong>{{ $errors->first('meters') }}</strong>
                        </span>
                    @endif

                  </div>

                  <div class="col-md-6">
                      <input id="cmeters" type="number" class="form-control" name="cmeters" value="{{ old('cmeters') }}" step="1" min="0" max="99" placeholder="cm">

                      @if ($errors->has('cmeters'))
                          <span class="help-block">
                              <strong>{{ $errors->first('cmeters') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
            </div>
          </div>
        </div>


        <!--Track-Mark input field-->
        <div id="track_mark">
          <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
            <div class="form-group{{ $errors->has('minutes') ? ' has-error' : '' }}">
              <div class="form-group{{ $errors->has('seconds') ? ' has-error' : '' }}">
                <div class="form-group{{ $errors->has('decimal') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Mark</label>
                  <div class="col-md-8">
                    <div class="col-md-3">

                      <input id="hours" type="number" class="form-control" name="hours" value="{{ old('hours') }}"  step="1" min="0" placeholder="hours">
                      @if ($errors->has('hours'))
                          <span class="help-block">
                              <strong>{{ $errors->first('hours') }}</strong>
                          </span>
                      @endif

                    </div>

                    <div class="col-md-3">
                      <input id="minutes" type="number" class="form-control" name="minutes" value="{{ old('minutes') }}" step="1" min="0" max="59" placeholder="min">

                      @if ($errors->has('minutes'))
                          <span class="help-block">
                              <strong>{{ $errors->first('minutes') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="col-md-3">
                      <input id="seconds" type="number" class="form-control" name="seconds" value="{{ old('seconds') }}" step="1" min="0" max="59" placeholder="sec">

                      @if ($errors->has('seconds'))
                          <span class="help-block">
                              <strong>{{ $errors->first('seconds') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="col-md-3">
                      <input id="decimal" type="number" class="form-control" name="decimal" value="{{ old('decimal') }}" step="1" min="0" max="99" placeholder="00">

                      @if ($errors->has('decimal'))
                          <span class="help-block">
                              <strong>{{ $errors->first('decimal') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--Score input field-->
        <div class="form-group">
            <label for="result" class="col-md-4 control-label">Is Handed?</label>
            <div class="col-md-6">
              <input id="handed" name="handed" type="checkbox" >
            </div>
        </div>


        <!--Wind input field-->
        <div class="form-group{{ $errors->has('wind') ? ' has-error' : '' }}">
            <label for="wind" class="col-md-4 control-label">Wind (nullable)</label>
            <div class="col-md-6">
                <input id="wind" type="text" class="form-control" name="wind" value="{{ old('wind') }}" placeholder="+1.5, -0.7">

                @if ($errors->has('wind'))
                    <span class="help-block">
                        <strong>{{ $errors->first('wind') }}</strong>
                    </span>
                @endif
            </div>
        </div>



        <!--Score input field-->
        <div class="form-group{{ $errors->has('score') ? ' has-error' : '' }}">
            <label for="result" class="col-md-4 control-label">Score Points (nullable)</label>
            <div class="col-md-6">
                <input id="score" type="number" class="form-control" name="score" value="{{ old('score') }}"  min="0">

                @if ($errors->has('score'))
                    <span class="help-block">
                        <strong>{{ $errors->first('score') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Score input field-->
        <div class="form-group">
            <label for="result" class="col-md-4 control-label">Is Recordable?</label>
            <div class="col-md-6">
              <input id="recordable" name="recordable" type="checkbox" checked>
            </div>
        </div>


        <!--Records input fields-->
        {{-- @foreach($records as $record)

            <div class="form-group">
                <label for="records[]" class="col-md-4 control-label">{{$record->acronym}}</label>
                <input id="records[]" name="records[]" type="checkbox" value="{{$record->id}}">
            </div>
        @endforeach --}}



        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{ route('result.index') }}">Cancel</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Save Result
                </button>
            </div>
            <div class="col-md-2">
                <button type="button" id="refresh" class="btn btn-default">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </button>
            </div>
        </div>


    {!! Form::close() !!}
@endsection
@section('scripts')


  <script type="text/javascript">
      jQuery(document).ready(function(){


          getDates();
          getEvents();
          markInput();

          $('#type').on('change',function(){
              getEvents();
              markInput();
          });

          $('#competition_id').on('change',function(){
              getDates();
          });


          /* Functions */
          function getEvents() {
              document.getElementById('event_id').innerHTML = "";
              if( $('#type').val()==="relay" ){
                  $("#relay_id").show();
                  $("#athlete_label").text("Team");
              }else{
                  $("#relay_id").hide();
                  $("#athlete_label").text("Athlete");

              }
              var myUrl = '/dashboard/result/events';
              var myData = {
                type: $('#type').val(),
              };
              var events;

              axios.post(myUrl, myData )
              .then(function (response) {
                  $.each(response.data, function( index, value ) {
                      $('#event_id').append($('<option>', {
                          value: value.id,
                          text: value.name + ' ' + value.season + ' ' + value.gender
                      }));
                  });
              })
              .catch(function (error) {
                  console.log('error');
              });
              return;
          }

          function markInput() {
              if( $('#type').val()==="field" ){
                  $("#field_mark").show();

                  $("#track_mark").hide();
              }else{
                  $("#field_mark").hide();
                  $("#track_mark").show();
              }

              return;
          }

          function getDates() {
              document.getElementById('date').innerHTML = "";

              var myUrl = '/dashboard/result/dates';
              var myData = {
                competition: $('#competition_id').val(),
              };
              var dates;

              axios.post(myUrl, myData )
              .then(function (response) {
                  $.each(response.data, function( index, value ) {
                      $('#date').append('<option value="'+value+'">'+value+'</option>');
                  });
              })
              .catch(function (error) {
                  console.log('error');
              });
              return;
          }




      });

  </script>

@endsection
