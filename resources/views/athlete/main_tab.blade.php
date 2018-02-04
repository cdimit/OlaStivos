<div class="row">
    <div class="col-sm-6">
    <div class="well">
        <p><h1>{{$athlete->name}}</h1></p>
        <p>
            <ul class="list-inline">
                @if ( $athlete->gender == 'male')
                    <li class="list-inline-item seperator">ΑΝΔΡΑΣ</li>
                @else
                    <li class="list-inline-item seperator  uppercase">ΓΥΝΑΙΚΑ</li>
                @endif
                <li class="list-inline-item seperator">
                  @if($athlete->dob)
                    {{date('d-m-Y', strtotime($athlete->dob))}}
                  @else
                    {{$athlete->year}}
                  @endif
                </li>
                <li class="list-inline-item">{{$athlete->club->acronym}}</li>
            </ul>
        </p>
        <p>
            <!--      Achievements      -->
            <ul class="list-group">
                <li class="list-group-item borderless" style="font-size:12px "><b>Επιτεύγματα:</b></li>

                @foreach($NRs as $event => $NR)
                    <li class="list-group-item icon icon-bullet">
                        <span class="list-group-item-achievement">
                            <img src="/img/nr.png" class="img-responsive center">
                        </span>
                        Παγκύπριο Ρεκόρ {{App\Event::find($event)->sezon}}: &ensp; <i>{{$NR->event->name}}   &ensp;  <b>{{$NR->markstr}}</b></i>
                    </li>
                @endforeach

                @foreach($NURs as $event => $NUR)
                    <li class="list-group-item icon icon-bullet">
                        <span class="list-group-item-achievement">
                            <img src="/img/nru23.png" class="img-responsive center">
                        </span>
                        Παγκύπριο Ρεκόρ U23 {{App\Event::find($event)->sezon}}: &ensp; <i>{{$NUR->event->name}} &ensp; <b>{{$NUR->markstr}}</b></i>
                    </li>
                @endforeach

                @foreach($NJRs as $event => $NJR)
                    <li class="list-group-item icon icon-bullet">
                        <span class="list-group-item-achievement">
                            <img src="/img/nrjunior.png" class="img-responsive center">
                        </span>
                        Παγκύπριο Ρεκόρ U20 {{App\Event::find($event)->sezon}}: &ensp; <i> {{$NJR->event->name}} &ensp;<b>{{$NJR->markstr}}</b></i>
                    </li>
                @endforeach

                @foreach($NYRs as $event => $NYR)
                    <li class="list-group-item icon icon-bullet">
                        <span class="list-group-item-achievement">
                            <img src="/img/nryouth.png" class="img-responsive center">
                        </span>
                        Παγκύπριο Ρεκόρ U18 {{App\Event::find($event)->sezon}}: &ensp; <i> {{$NYR->event->name}} &ensp; <b>{{$NYR->markstr}}</b></i>
                    </li>
                @endforeach

                @foreach($NU16Rs as $event => $NU16R)
                    <li class="list-group-item icon icon-bullet">
                        <span class="list-group-item-achievement">
                            <img src="/img/nryouth.png" class="img-responsive center">
                        </span>
                        Παγκύπριο Ρεκόρ U16 {{App\Event::find($event)->sezon}}: &ensp; <i> {{$NU16R->event->name}} &ensp; <b>{{$NU16R->markstr}}</b></i>
                    </li>
                @endforeach

                @if($nwins>0)
                <li class="list-group-item icon icon-bullet">
                    <span class="list-group-item-achievement">
                        <img src="/img/first.png" class="img-responsive center">
                    </span>
                    Παγκύπριες νίκες: &ensp; <i><b>{{$nwins}}</b></i>
                </li>
              @endif
            </ul>
        </p>
    </div>
    </div>
    <div class="col-sm-6">
        <p>
            <img src="{{ $athlete->picture }}" class="img-responsive center" style="max-width: auto; max-height: auto; display: block; margin: auto auto;">
        </p>
    </div>
    </div>

    <div class="row" style="margin-top:10px">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Καλύτερες Επιδόσεις Σεζόν - SB</div>
            <div class="panel-body">
                <table class="table table-condensed table-responsive">
                    <thead>
                        <tr>
                            <th>Αγώνισμα</th>
                            <th>Αγώνας</th>
                            <th>Επίδοση</th>
                            <th>Πόντοι</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sbs as $sb)
                            <tr>
                                <th scope="row">{{$sb->event->name}} @if($sb->event->season=="indoor") Κλειστού @endif</th>
                                <td><a href="/competition/{{$sb->competition->id}}">{{$sb->competition->name}}</a></td>
                                <td>{{$sb->markstr}}</td>
                                <td>{{$sb->score}}</td>

                            </tr>

                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Ατομικά Ρεκόρ - PB</div>
            <div class="panel-body">
                <table class="table table-condensed table-responsive">
                    <thead>
                        <tr>
                            <th>Αγώνισμα</th>
                            <th>Αγώνας</th>
                            <th>Επίδοση</th>
                            <th>Πόντοι</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pbs as $pb)
                            <tr>
                                <th scope="row">{{$pb->event->name}} @if($pb->event->season=="indoor") Κλειστού @endif</th>
                                <td><a href="/competition/{{$pb->competition->id}}">{{$pb->competition->name}}</a></td>
                                <td>{{$pb->markstr}}</td>
                                <td>{{$pb->score}}</td>

                            </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col-sm-12">
        <!-- SB History -->
        @if(!$sbHistory->isEmpty())
            <div class="panel panel-default">
                <div class="panel-heading">Πρόοδος SB μέσα στα χρόνια ανά αγώνισμα</div>
                <dir class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <th>Σεζόν</th>
                            @foreach($sbHistory->first()->keys() as $event)

                                <th>{{\App\Event::find($event)->name}} @if(\App\Event::find($event)->season=="indoor") Κλειστού @endif</th>

                            @endforeach
                        </thead>
                        <tbody>

                            @foreach($sbHistory as $year=>$sb)
                                <tr>
                                    <td>Καλύτερες επιδόσεις {{$year}}</td>
                                    @foreach($sb->values() as $s)
                                        @if($s)
                                            <td><a href="/competition/{{$s->competition->id}}">{{$s->markstr}}</a></td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </dir>
            </div>
        @endif


        <!-- GRAPHS -->


        <!-- GRAPH TABS FOR PBS -->
    {{--                            <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                Αναλυτική Πρόοδος ανά αγώνισμα
                <!-- TABS List -->
                <ul class="nav nav-tabs">
                    @foreach($chartsResults as $event_id =>$chart)
                        <li @if(array_keys($chartsResults)[0]== $event_id) class="active" @endif><a href="#tabResult{{$event_id}}" data-toggle="tab">{{\App\Event::find($event_id)->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @foreach($chartsResults as $event_id =>$chart)

                    <div @if(array_keys($chartsResults)[0]== $event_id) class="tab-pane fade in active"@else class ="tab-pane fade" @endif id="tabResult{{$event_id}}">

                        <canvas id="resultsChart{{$event_id}}" width="400" height="200"></canvas>
                    </div>
                    @endforeach


                </div>
            </div>

        </div>
        <!-- -->

        <!-- GRAPH TABS FOR PBS -->
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                Πρόοδος προσωπικής καλύτερης επίδοσης (PB) ανά αγώνισμα
                <!-- TABS List -->
                <ul class="nav nav-tabs">
                    @foreach($chartsPbs as $event_id =>$chart)
                        <li @if(array_keys($chartsPbs)[0]== $event_id) class="active" @endif><a href="#tabPb{{$event_id}}" data-toggle="tab">{{\App\Event::find($event_id)->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @foreach($chartsPbs as $event_id =>$chart)

                    <div @if(array_keys($chartsPbs)[0]== $event_id) class="tab-pane fade in active"@else class ="tab-pane fade" @endif id="tabPb{{$event_id}}">

                        <canvas id="pbsChart{{$event_id}}" width="400" height="200"></canvas>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> --}}
        <!-- -->
    </div>
    </div>
