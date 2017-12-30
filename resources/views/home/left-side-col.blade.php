<!-- 10 EPOMENOI AGWNES -->
<div class="panel panel-2">
  <div class="panel-heading">Επόμενοι Αγώνες</div>
  <div class="panel-body">
    @if($competitions->first())
      <table class="table table-sm table-responsive">
        <col width="35%" />
        <col width="65%" />
        <thead class="thead">
          <tr>
            <th>Ημερομηνία</th>
            <th>Αγώνας</th>
          </tr>
        </thead>
        <tbody>

          @foreach($competitions as $competition)
            <tr>
              @if($competition->date_start == $competition->date_finish)
                <td>{{date('d.m', strtotime($competition->date_start))}}</td>
              @else
                <td>{{date('d.m', strtotime($competition->date_start))}} - {{date('d.m', strtotime($competition->date_finish))}}</td>
              @endif
              <td class="grow"><a href="/competition/{{$competition->id}}">{{$competition->name}}</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>

    @else
      <i style="margin-top: -20px;">Δεν υπάρχουν επόμενοι αγώνες</i>
    @endif
    <a href="/calendar" class="btn btn-default btn-sm" role="button">Αναλυτικό ημερολόγιο αγώνων</a>
  </div>
</div>


<!-- COMPETITION COWNTDOWN -->
<!-- An den exei competitions den emfanizete -->
@if($countdownComp)
  <div class="panel panel-2">
    <div class="panel-heading">Αντίστροφη Μέτρηση</div>
    <div class="panel-body">

      <a href="{{ route('competition.show',['competition'=>$countdownComp->id]) }}">
        <h2 style="text-align: center; font-weight: bold; margin-top: 0; margin-bottom: 0;">
          {{\Carbon\Carbon::now()->diffInDays(new \Carbon\Carbon($countdownComp->date_start))}} μέρες
        </h2>
        <h2 style="text-align: center; margin-top: 0; margin-bottom: 0;">
          {{$countdownComp->name}}
        </h2>
      </a>

    </div>
  </div>
@endif


<!-- BIRTHDAY ATHLETE -->
<!-- An den exei athlitis genethlia den emfanizete -->
@if($birthdayAthlete)
  <div class="panel panel-2">
    <div class="panel-heading">Έχει Γενέθλια Σήμερα!</div>
    <div class="panel-body">
      <div well="">
        <img src="{{ $birthdayAthlete->picture }}" class="img-responsive center" style="max-width: auto; max-height: auto;">
        <a href="{{ route('athlete.show',['athlete'=>$birthdayAthlete->id]) }}">
            <h4><b>
            {{$birthdayAthlete->first_name}} {{$birthdayAthlete->last_name }} - {{\Carbon\Carbon::now()->diffInYears(new \Carbon\Carbon($birthdayAthlete->dob))}} ετών
            </b></h4>
        </a>
      </div>
    </div>
  </div>
@endif
