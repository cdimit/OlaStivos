@extends('layouts.app')
@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style type="text/css">
    .form-horizontal{
        /*font-size: 11px;*/
    } 
    .form-horizontal .control-label{
    /* text-align:right; */
    text-align:left;

    }
</style>

@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>National Records</h2></div>               
                <div class="panel-body">
                    <!-- Search Form -->
                    <div class="well"> 
                    {!! Form::open(
                            array(
                                'route' => 'record.searchNRs', 
                                'class' => 'form-inline'
                                )
                            ) 
                        !!}
                        
                        {{ csrf_field() }} 
                        <div class="form-group">
                            <label for="category">Age Category</label>
                            <select  id="category" name="category" class="form-control">
                                <option value="Senior">Senior</option>
                                <option value="U23">U23</option>
                                <option value="Junior">Junior</option>
                                <option value="Youth">Youth</option>
                            </select>
                        </div>
                      
                        <div class="form-group">
                            <label for="season">Season</label>
                            <select  id="season" name="season" class="form-control">
                                <option value="All Seasons">All Seasons</option>
                                <option value="indoor">Indoor</option>
                                <option value="outdoor">Outdoor</option>
                                <option value="road">Road</option>
                                <option value="cross country">Cross Country</option>
                            </select>
                        </div>
                      

                        <button type="submit" class="btn btn-default">Search National Records</button>
                    {!! Form::close() !!}
                    </div>

                    <!-- Main Content -->
                    <h3>{{$category}} Records - {{strtoupper($season)}}</h3>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Men</div>
                            <div class="panel-body">
                                <table width="100%">
                                    @foreach($records as $record)
                                        @if($record && $record->event->gender == 'male')
                                            <tr>
                                                <td>{{$record->event->name}}</td>
                                                <td>
                                                <a href="/athlete/{{$record->athlete->id}}">
                                                {{$record->athlete->first_name}} {{$record->athlete->last_name}}</a>
                                                </td>
                                                <td>{{$record->mark}}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </table> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Women</div>
                            <div class="panel-body">
                                <table width="100%">
                                    @foreach($records as $record)
                                        @if($record && $record->event->gender == 'female')
                                            <tr>
                                                <td>{{$record->event->name}}</td>
                                                <td>
                                                <a href="/athlete/{{$record->athlete->id}}">
                                                {{$record->athlete->first_name}} {{$record->athlete->last_name}}</a>
                                                </td>
                                                <td>{{$record->mark}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
@endsection

