<!-- TOP LIST SEASON -->
<div class="panel panel-1 with-nav-tabs">
  <div class="panel-heading">
    Καλύτερες Επιδόσεις Σεζόν- Ανοικτός Στίβος
    <!-- TABS List -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tabMaleLead" data-toggle="tab">Άνδρες</a></li>
      <li><a href="#tabFemaleLead" data-toggle="tab">Γυναίκες</a></li>
    </ul>
  </div>
  <div class="panel-body">
    <div class="tab-content">

      <!-- ****************************************** -->
      <!--                Male TAB                    -->
      <!-- ****************************************** -->
      <div class="tab-pane fade in active" id="tabMaleLead">
        <table class="table table-sm table-responsive table-border">
          <col width="28%" />
          <col width="48%" />
          <col width="24%" />
          <thead class="thead">
            <tr>
              <th>Αγώνισμα</th>
              <th>Αθλητής</th>
              <th>Επίδοση</th>
            </tr>
          </thead>
          <tbody>

            @foreach($maleLeaders as $lead)
              @if($lead)
              <tr>
                <td>{{$lead->event->name}}</td>
                <td><a href="{{ route('athlete.show',['athlete'=>$lead->athlete->id]) }}">{{$lead->athlete->name}} </a></td>
                <td><a href="{{ route('competition.show',['competition'=>$lead->competition->id]) }}">{{$lead->markstr}}</a></td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- ****************************************** -->
      <!--                Female TAB                    -->
      <!-- ****************************************** -->
      <div class="tab-pane fade in" id="tabFemaleLead">
        <table class="table table-sm table-responsive">
          <col width="28%" />
          <col width="48%" />
          <col width="24%" />
          <thead class="thead">
              <th>Αγώνισμα</th>
              <th>Αθλητής</th>
              <th>Επίδοση</th>
            </tr>
          </thead>
          <tbody>

            @foreach($femaleLeaders as $lead)
              @if($lead)
              <tr>
                <td>{{$lead->event->name}}</td>
                <td><a href="{{ route('athlete.show',['athlete'=>$lead->athlete->id]) }}">{{$lead->athlete->name}}</a></td>
                <td><a href="{{ route('competition.show',['competition'=>$lead->competition->id]) }}">{{$lead->markstr}}</a></td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
  <div style="text-align:center; margin-bottom: 10px;">
    <a href="/toplist" class="btn btn-default btn-sm" role="button" >Περισσότερες Τοπ Λίστες</a>
  </div>
</div>


<!-- ADVERTISEMENT -->
<div class="well" style="margin-top: 20px; ">
  ADVERTISEMENT
</div>

<!-- NATIONAL RECORDS -->
<div class="panel panel-1 with-nav-tabs">
  <div class="panel-heading">
    Παγκύπρια Ρεκόρ - Ανοικτός Στίβος
    <!-- TABS List -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tabMale" data-toggle="tab">Άνδρες</a></li>
      <li><a href="#tabFemale" data-toggle="tab">Γυναίκες</a></li>
    </ul>
  </div>
  <div class="panel-body">
    <div class="tab-content">

      <!-- ****************************************** -->
      <!--                Male TAB                    -->
      <!-- ****************************************** -->
      <div class="tab-pane fade in active" id="tabMale">
        <table class="table table-sm table-responsive table-border">
          <col width="28%" />
          <col width="48%" />
          <col width="24%" />
          <thead class="thead">
            <tr>
              <th>Αγώνισμα</th>
              <th>Αθλητής</th>
              <th>Επίδοση</th>
            </tr>
          </thead>
          <tbody>

            @foreach($maleNRs as $nr)
              @if($nr)
              <tr>
                <td>{{$nr->event->name}}</td>
                <td><a href="{{ route('athlete.show',['athlete'=>$nr->athlete->id]) }}">{{$nr->athlete->name}}</a></td>
                <td><a href="{{ route('competition.show',['competition'=>$nr->competition->id]) }}">{{$nr->markstr}}</a></td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>


      <!-- ****************************************** -->
      <!--                Female TAB                    -->
      <!-- ****************************************** -->
      <div class="tab-pane fade in" id="tabFemale">
        <table class="table table-sm table-responsive">
          <col width="28%" />
          <col width="48%" />
          <col width="24%" />
          <thead class="thead">
              <th>Αγώνισμα</th>
              <th>Αθλητής</th>
              <th>Επίδοση</th>
            </tr>
          </thead>
          <tbody>

            @foreach($femaleNRs as $nr)
              @if($nr)
              <tr>
                <td>{{$nr->event->name}}</td>
                <td><a href="{{ route('athlete.show',['athlete'=>$nr->athlete->id]) }}">{{$nr->athlete->name}}</a></td>
                <td><a href="{{ route('competition.show',['competition'=>$nr->competition->id]) }}">{{$nr->markstr}}</a></td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
  <div style="text-align:center; margin-bottom: 10px;">
    <a href="/records/nationals" class="btn btn-default btn-sm" role="button" >Περισσότερα Παγκύπρια Ρεκόρ</a>
  </div>
</div>


<!-- PHOTO OF THE DAY -->
<div class="panel panel-1">
  <div class="panel-heading">Φωτογραφία Ημέρας</div>
  <div class="panel-body">

      <img src="https://image.freepik.com/free-photo/person-running_1112-546.jpg" class="img-responsive center">

  </div>
</div>