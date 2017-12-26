<div class="col-sm-12">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
            <ul class="nav nav-tabs">

              <li class="dropdown">
                <a href="#" data-toggle="dropdown">Χρονιά<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    @foreach($results as $key => $value)
                        <li><a href="#tab{{$key}}" data-toggle="tab">{{$key}}</a></li>
                    @endforeach

                </ul>
              </li>
            </ul>
        </div>

        <div class="panel-body">
            <div class="tab-content">


            @foreach($results as $key => $value)

                <div class="tab-pane fade in active" id="tab{{$key}}">

                    <div class="panel panel-default">
                        <div class="panel-heading">Αποτελέσματα {{$key}}</div>
                        <div class="panel-body">
                            <table class="table table-condensed table-responsive">
                                <thead>
                                    <tr>
                                        <th>Ημερομηνία</th>
                                        <th>Επίδοση</th>
                                        <th>Θέση</th>
                                        <th>Αγώνισμα</th>
                                        <th>Αγώνας</th>
                                        <th>Τοποθεσία</th>
                                        <th>Πόντοι</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @foreach($value as $result)
                                        <tr>
                                            <th scope="row">{{$result->date}}</th>
                                            <th>{{$result->markstr}}</td>
                                            <td>{{$result->position}}</th>
                                            <td>{{$result->event->name}} {{$result->event->sezon}}</td>
                                            <td><a href="/competition/{{$result->competition->id}}">{{$result->competition->name}}</a></td>
                                            <td>{{$result->competition->city}}, {{$result->competition->country}}</td>
                                            <td>{{$result->score}}</td>

                                        </tr>

                                    @endforeach
                                </tbody>

                            </table>

                        </div>
                    </div>

                </div>

            @endforeach
            </div>

        </div>

    </div>
</div>