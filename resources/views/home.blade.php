@extends('layouts.app')

@section('styles')
<style>

.navbar-default{
    background: transparent;
    border:none !important;
}

.navbar-nav>li>a:hover{
    color:#1a1a1a;
} 
.collapse.in{
    
    background-color:#f0f0f0 !important;
}
.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:hover, .navbar-inverse .navbar-nav>.active>a:focus
.spacer{
   background-color:#888;   
}

.spacer{
    height:100px;
}

.divWithBgImage {
  width: 100%;
  height: 200px;
  background-image: url(https://image.freepik.com/free-photo/person-running_1112-546.jpg);
  background-repeat: no-repeat;
  background-size: 100% ;
  background-position: center -230px;
  margin-bottom: 10px;
/*
  background-size: 100% 100%; //stretch resize
*/
}

table {
  table-layout: fixed;
  width: 100%;   
  font-size: 11px;
}

th,td {
  border-style: solid transparent;
  border-width: 0.01px;
  word-wrap: break-word;
}

/* Link CSS*/
a{
   color: #15ACA0;
}
a:hover {
color: black;
}
   

/* PANEL CSS */
.panel {
    border: 0.1px solid #dddddd;
    border-radius: 0.1px;
}

.panel > .panel-heading {
    height: 20px;
    padding:0;
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    color:black;
    background-color: transparent;
    border-top: solid 6px;
    border-top-color: #15ACA0;
}
/*
.panel > .panel-body {

}
*/
.btn {
  background-color: #15ACA0;
  border-color:  #15ACA0;
}

</style>
@endsection

@section('content')
<div class="divWithBgImage">
</div>

<div class="container">  
  <div class="row">
    <div class="col-md-8 col-md-offset-2">


      <div class="row">
        <div class="col-sm-6">
          <div class="panel">
            <div class="panel-heading">Επόμενοι Αγώνες</div>
            <div class="panel-body">
              @if($competitions->first())
                <table class="table table-sm table-responsive">
                  <col width="25%" />
                  <col width="25%" />
                  <col width="50%" />
                  <thead class="thead">
                    <tr>
                      <th>Ημερομηνία έναρξης</th>
                      <th>Ημερομηνία λήξης</th>
                      <th>Αγώνας</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach($competitions as $competition)
                      <tr>
                        <td>{{date('d-m-Y', strtotime($competition->date_start))}}</td>
                        <td>{{date('d-m-Y', strtotime($competition->date_finish))}}</td>
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
        </div>
        <div class="col-sm-6">
          <div class="panel">
            <div class="panel-heading">Links</div>
            <div class="panel-body">
              <a href="{{ route('athlete.show',['athlete'=>1]) }}" id="startchange">Athlete Page: {{\App\Athlete::find(1)->first_name}} {{\App\Athlete::find(1)->last_name}}</a>
              <br>
              <a href="{{ route('competition.show',['competition'=>1]) }}">Competition Page: {{\App\Competition::find(1)->name}}</a>
              <br>
              <a href="{{ route('club.show',['club'=>1]) }}">Club Page: {{\App\Club::find(1)->name}}</a>

            </div>
          </div>
        </div>
      </div>

      <!-- An den exei athlitis genethlia den emfanizete -->
      @if($birthdayAthlete)
         <div class="row">
          <div class="col-sm-5">
            <div class="panel">

              <div class="panel-heading">Έχει Γενέθλια Σήμερα!</div>
              <div class="panel-body">
                <div well="">
                  <img src="/storage/{{ $birthdayAthlete->picture }}" class="img-responsive center" style="max-width: auto; max-height: auto;">
                  <a href="{{ route('athlete.show',['athlete'=>$birthdayAthlete->id]) }}">
                    {{$birthdayAthlete->first_name}} {{$birthdayAthlete->last_name }} - {{\Carbon\Carbon::now()->diffInYears(new \Carbon\Carbon($birthdayAthlete->dob))}} ετών
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif


      <p>
        <img src="https://aff.bstatic.com/images/hotel/840x460/201/2016824.jpg" class="img-responsive center" style="max-width: auto; max-height: auto;">
        <img src="https://aff.bstatic.com/images/hotel/840x460/201/2016824.jpg" class="img-responsive center" style="max-width: auto; max-height: auto;">
      </p>


    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){     
	//Navbar transparent before scrolling down  
   	var scroll_start = 0;
   	var startchange = $('#startchange');
   	console.log(startchange.length);
   	var offset = startchange.offset();
   	console.log(offset);
   	if (startchange.length){
	   $(document).scroll(function() { 
	      scroll_start = $(this).scrollTop();
	      if(scroll_start > offset.top) {
	          $(".navbar-default").css('background-color', 'black');
	       } else {
	          $('.navbar-default').css({"background-color":"transparent","transition":"background-color 250ms linear"});
	       }
	   });
    }
});
</script>
@endsection