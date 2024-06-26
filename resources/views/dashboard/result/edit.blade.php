@extends('layouts.dashboard')

@section('content')

    <p><u><h4>Edit Result</h4></u></p>
    {!! Form::model($result, ['route' => ['result.update',$result->id],'class'=>'form-horizontal']) !!}

        {{ Form::token() }}
        {{ method_field('PATCH') }}


        <!--Competition input field-->
        <div class="form-group{{ $errors->has('competition_id') ? ' has-error' : '' }}">
            <label for="competition_id" class="col-md-4 control-label">Competition</label>
            <div class="col-md-6">
                <select  id="competition_id" name="competition_id" class="selectpicker" data-show-subtext="true" data-live-search="true">
                    @foreach($competitions as $competition)
                        <option @if($competition->id ==$result->competition->id) selected @endif value="{{$competition->id}}">{{$competition->name}} {{$competition->date_start}}</option>
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
                        <option value="{{$type}}" @if($result->event->type==$type) selected @endif>{{$type}}</option>
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
                        <option @if($event->id ==$result->event->id) selected @endif value="{{$event->id}}">{{$event->name}} {{$event->season}} {{$event->gender}}</option>
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
                        <option @if($athlete->id ==$result->athlete->id) selected @endif value="{{$athlete->id}}">{{$athlete->first_name}} {{$athlete->last_name}} {{$athlete->dob}}</option>
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
                    @foreach($result->relayAthletes as $athlete)
                        <option selected value="{{$athlete->id}} {{$athlete->year}}">{{$athlete->first_name}} {{$athlete->last_name}} {{$athlete->dob}}</option>
                    @endforeach
                    @foreach($athletes->diff($result->relayAthletes) as $athlete)
                        <option value="{{$athlete->id}} {{$athlete->year}}">{{$athlete->first_name}} {{$athlete->last_name}} {{$athlete->dob}}</option>
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
        <div class="form-group{{ $errors->has('race') ? ' has-error' : '' }}">
            <label for="race" class="col-md-4 control-label">Race</label>
            <div class="col-md-6">
                {{ Form::text('race',null,["class"=> 'form-control','required'])}}

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
                {{ Form::text('position',null,["class"=> 'form-control'])}}

                @if ($errors->has('position'))
                    <span class="help-block">
                        <strong>{{ $errors->first('position') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Position input field-->
        <div class="form-group{{ $errors->has('overall') ? ' has-error' : '' }}">
            <label for="overall" class="col-md-4 control-label">Overall</label>
            <div class="col-md-6">
                {{ Form::text('overall',null,["class"=> 'form-control'])}}

                @if ($errors->has('overall'))
                    <span class="help-block">
                        <strong>{{ $errors->first('overall') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Mark input field-->
        <div class="form-group{{ $errors->has('mark') ? ' has-error' : '' }}">
            <label for="mark" class="col-md-4 control-label">Mark</label>
            <div class="col-md-6">
                {{ Form::text('mark',null,["class"=> 'form-control'])}}

                @if ($errors->has('mark'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mark') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Is Handed input field-->
        <div class="form-group" id="handed">
            <label for="result" class="col-md-4 control-label">Is Handed?</label>
            <div class="col-md-6">
              <input id="handed" name="handed" type="checkbox" @if($result->isHanded()) checked @endif>
            </div>
        </div>

        <!--Wind input field-->
        <div class="form-group{{ $errors->has('wind') ? ' has-error' : '' }}">
            <label for="wind" class="col-md-4 control-label">Wind (nullable)</label>
            <div class="col-md-6">
                {{ Form::text('wind',null,["class"=> 'form-control'])}}

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
                {{ Form::text('score',null,["class"=> 'form-control'])}}
                @if ($errors->has('score'))
                    <span class="help-block">
                        <strong>{{ $errors->first('score') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <!--Is recordable field-->
        <div class="form-group">
            <label for="recordable" class="col-md-4 control-label">Is Recordable?</label>
            <div class="col-md-6">
              <input id="recordable" name="recordable" type="checkbox" @if($result->is_recordable) checked @endif>
            </div>
        </div>


        <div class="form-group">

            <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-outline-primary" href="{{route('result.index')}}">Cancel</a>
            </div>
            <div class="col-md-2">
                {{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}
            </div>
        </div>


    {!! Form::close() !!}
@endsection
@section('scripts')

  <script type="text/javascript">
      jQuery(document).ready(function(){

          getDates();
          getEvents();

          // $('#relay_id').hide();

          $('#type').on('change',function(){
              getEvents();
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

              if( $('#type').val()==="field" ){
                  $("#handed").hide();
              }else{
                  $("#handed").show();

              }
              
              var myUrl = '/dashboard/result/events';
              var myData = {
                type: $('#type').val(),
              };
              var events;

              axios.post(myUrl, myData )
              .then(function (response) {
                  $.each(response.data, function( index, value ) {
                      if( value.id=={{$result->event->id}}){
                        $('#event_id').append($('<option>', {
                            value: value.id,
                            text: value.name + ' ' + value.season + ' ' + value.gender,
                            selected: true
                        }));
                      }else{
                        $('#event_id').append($('<option>', {
                            value: value.id,
                            text: value.name + ' ' + value.season + ' ' + value.gender
                        }));
                      }

                  });
              })
              .catch(function (error) {
                  console.log('error');
              });
              return;
          }

          function getDates() {
              document.getElementById('date').innerHTML = "<option value='{{$result->date}}' selected>{{$result->date}}</option>";

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
