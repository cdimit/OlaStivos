@extends('layouts.app')

@section('styles')
    <link href="{{ asset('/css/forms/form-in-well.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/headings/heading-in-pages.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/images/img-in-div.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="container" style="background-color: #F9F9F9;">
    <div class="row">

        <div class="col-md-12">
            <div class="col-md-6">

                {{-- <div class="col-md-12 image-back"  style="margin-bottom: 10px"> --}}
                <h1>Παγκύπρια Ρεκόρ</h1>
                <div class="well">
                    <h4>Ψάξε Παγκύπρια Ρεκόρ:</h4>
                    <!-- Search Form -->
                    {!! Form::open(
                            array(
                                'route' => 'record.searchNRs', 
                                'class' => 'form-horizontal'
                                )
                            ) 
                        !!}
                        
                        {{ csrf_field() }} 
                        <div class="form-group">
                            <div class="col-xs-5 text-left">
                                <label for="category">Ηλικιακή Κατηγορία</label>
                            </div> 
                            <div class="col-xs-7">
                            <select  id="category" name="category" class="form-control">
                                <option value="Senior">Άνδρες/Γυναίκες</option>
                                <option value="U23">Κάτω των 23</option>
                                <option value="Junior">Έφηφοι/Νεανίδες</option>
                                <option value="Youth">Παίδες/Κορασίδες</option>
                            </select>
                            </div>
                            
                        </div>
                      
                        <div class="form-group">
                            <div class="col-xs-5 text-left">
                                <label for="season">Σεζόν</label>
                            </div>
                            <div class="col-xs-7">
                                <select  id="season" name="season" class="form-control">
                                    <option value="outdoor">Ανοικτός</option>
                                    <option value="indoor">Κλειστός</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-5 text-left">
                                <label for="gender">Φύλο</label>
                            </div>
                            <div class="col-xs-7">
                                <select  id="gender" name="gender" class="form-control">
                                    <option value="male">Άνδρες</option>
                                    <option value="female">Γυναίκες</option>
                                </select>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <div class="col-xs-2 text-left">
                                <button type="submit" class="btn btn-default">Ψάξε Παγκύπρια Ρεκόρ</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-6">
                <img class="img-in-div" src="https://images.pexels.com/photos/401896/pexels-photo-401896.jpeg?w=940&h=650&auto=compress&cs=tinysrgb">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">            
                <div class="panel-body">
                    <!-- Main Content -->
                    <h3> Παγκύπρια Ρεκόρ - {{strtoupper($season)}} -           

                    @if($events->first()->gender == 'male') 
                        @if($category == 'Senior')
                            Άνδρες
                        @elseif ($category == 'U23') 
                            Νέοι (U23)
                        @elseif ($category == 'Youth') 
                            έφηβοι
                        @else 
                            Παίδες
                        @endif
                    @else 
                        @if($category == 'Senior')
                            Γυναίκες
                        @elseif ($category == 'U23') 
                            Νέες (U23)
                        @elseif ($category == 'Youth') 
                            Νεανίδες
                        @else 
                            Κορασίδες
                        @endif
                    @endif 

                    </h3>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table width="100%">
                                    @foreach($records as $record)
                                        @if($record)
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

