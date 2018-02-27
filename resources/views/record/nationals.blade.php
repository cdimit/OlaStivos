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
                                <option value="U16">Παμπαίδες/Παγκορασίδες</option>
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
                <img class="img-in-div" src="/img/NRCOLLAGE.jpg">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- Main Content -->
                    <h3> Παγκύπρια Ρεκόρ - {{$events->first()->sezon}} -

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
                                <div class="table table-responsive">
                                <table width="100%">
                                    <th>Αγώνισμα</th>
                                    <th>Επίδοση</th>
                                    <th>Αθλητής</th>
                                    <th>Σύλλογος</th>
                                    <th>Τοποθεσία</th>
                                    <th>Ημερομηνία</th>

                                    @foreach($records as $record)
                                        <?php $index=0; ?>
                                        @foreach($record as $key => $sameRecord)
                                            <tr>
                                                <td>
                                                @if($index == 0)
                                                    {{$sameRecord->event->name}}
                                                @else
                                                    -
                                                @endif
                                                </td>
                                                <td>{{$sameRecord->markstr}} @if($events->first()->isOutdoor() && $sameRecord->event->isIndoor()) (i) @endif </td>
                                                <td>
                                                    <a href="/athlete/{{$sameRecord->athlete->id}}">{{$sameRecord->athlete->name}}</a>
                                                </td>
                                                <td><a href="/club/{{$sameRecord->athlete->club->id}}">{{$sameRecord->athlete->club->acronym}}</a></td>
                                                <td>
                                                    <a href="/competition/{{$sameRecord->competition->id}}">{{$sameRecord->competition->city}}</a>
                                                </td>
                                                <td>{{$sameRecord->date}}</td>

                                            </tr>
                                            <?php $index = $index + 1; ?>
                                        @endforeach
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

</div>
@endsection
