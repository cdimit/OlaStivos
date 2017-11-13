@extends('layouts.app')
@section('styles')
<style type="text/css">
    .form-horizontal{
        font-size: 12px;
    } 
    .form-horizontal .control-label{
    /* text-align:right; */
    text-align:left;

    }
    .form-group{
        margin-top:1px;
        margin-bottom: 1px;
    }

    label {
        line-height: 28px;
        color: black;
        font-style:bold;
    }

    h1{
        color: white;
        font-weight: bold;
        margin-top: 40px;
        margin-bottom: 20px; 
        text-shadow: -0.5px 0 black, 0 0.5px black, 0.5px 0 black, 0 -0.5px black;
    }
    h4{
        color: black;
        margin-top: 0px;
    }


    .form-control {
         width: auto; 
         height:auto; 
         font-size: 10px;
    }

    .well {
       background-color: rgba(245, 245, 245, 0.4);
       margin-left: 1px;
       margin-right: 1px;
       margin-top: 1px;
       margin-bottom: 1px;
       border: 0;
    }

    .image-back {
        background: url(https://images.pexels.com/photos/401896/pexels-photo-401896.jpeg?w=940&h=650&auto=compress&cs=tinysrgb) no-repeat center;
        background-size:100% 100%;
        min-height: 300px;
    }
</style>

@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 image-back"  style="margin-bottom: 10px">
            <h1>Παγκύπρια Ρεκόρ</h1>
            <div class="col-md-6 well">
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
                            <option value="cross country">Ανώμαλος Δρόμος</option>
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

