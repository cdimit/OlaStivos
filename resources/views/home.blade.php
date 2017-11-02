@extends('layouts.app')

@section('styles')
  <style>
    /* NAV BAR CSS */
    .navbar-default{
        /*background: transparent;*/
        background-color:rgba(0,0,0,0.1);
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
      /*filter: sepia(20%) saturate(100%) hue-rotate(150deg);*/
      background-repeat: no-repeat;
      background-size: 100% ;
      background-position: center -250px;
      margin-bottom: 10px;
    /*
      background-size: 100% 100%; //stretch resize
    */
    }

    @media screen and (max-width: 600px) {
      .divWithBgImage {
        visibility: hidden;
        clear: both;
        float: left;
        margin: 100px auto 5px 20px;
        width: 28%;
        display: none;
      }

    }

    /* Table CSS */
    table {
      table-layout: fixed;
      width: 100%;   
      font-size: 2vh;
    }

    th,td {
      border-style: solid transparent;
      border-width: 0.01px;
      word-wrap: normal;
    }

    td > .right{
      text-align: right;
    }


    /* Link CSS*/
    a{
       color: #1A6B70;
    }
    a:hover {
    color: black;
    }
       

    /* PANEL CSS */
    .panel {
        border: 0.1px solid #dddddd;
        border-radius: 0.1px;
        margin-bottom: 6px;

    }

    .panel-1 > .panel-heading {
        display: block;
        padding:0;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        color:black;
        background-color: transparent;
        border-top: solid 3px;
        border-top-color: #15ACA0;

    
    }

    .panel-2 > .panel-heading {
        height: 20px;
        padding-top: 0;
        text-align: left;
        font-weight: bold;
        font-size: 18px;
        color:black;
        background-color: transparent;
        border-left: solid 6px;
        border-left-color: #15ACA0;
    }
    
    .panel-2 > .panel-body {
        border-left: solid 6px;
        border-left-color: #15ACA0;
    }
    
    /* Button CSS */
    .btn {
      background-color: #15ACA0;
      border-color:  #15ACA0;
    }

    /* Panel padding */
    .padding-0{
      padding-right:0px;
      padding-left: 0px;
    }
    .padding-1{
      padding-right:1px;
      padding-left: 1px;
    }

    .padding-3{
      padding-right:5px;
      padding-left: 5px;
    }

    .bordered-left{
      border-left: 0.1px solid #15ACA0;
    }


    /* TABS heading font-size */
    .nav-tabs li a {font-size:14px;}
  </style>
@endsection

@section('content')
<div class="divWithBgImage">
</div>

<div class="container" id="startchange">  
  <div class="row">
    <!--***********-->
    <!-- 1st COLUMN-->
    <!--***********-->
    <div class="col-sm-3 padding-3">          
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

       <!-- An den exei athlitis genethlia den emfanizete -->
      @if($birthdayAthlete)
        <div class="panel panel-2">
          <div class="panel-heading">Έχει Γενέθλια Σήμερα!</div>
          <div class="panel-body">
            <div well="">
              <img src="/storage/{{ $birthdayAthlete->picture }}" class="img-responsive center" style="max-width: auto; max-height: auto;">
              <a href="{{ route('athlete.show',['athlete'=>$birthdayAthlete->id]) }}">
                  <h4><b>
                  {{$birthdayAthlete->first_name}} {{$birthdayAthlete->last_name }} - {{\Carbon\Carbon::now()->diffInYears(new \Carbon\Carbon($birthdayAthlete->dob))}} ετών
                  </b></h4>
              </a>
            </div>
          </div>
        </div>
      @endif

    </div>

    <div class="col-lg-9">
      <div class="row">

        

        <!--***********-->
        <!-- 2nd COLUMN-->
        <!--***********-->
        <div class="col-sm-8">


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
                          <td><a href="{{ route('athlete.show',['athlete'=>$lead->athlete->id]) }}">{{$lead->athlete->first_name}} {{$lead->athlete->last_name}}</a></td>
                          <td><a href="{{ route('competition.show',['competition'=>$lead->competition->id]) }}">{{$lead->mark}}</a></td>
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
                      
                      @foreach($femaleNRs as $lead)
                        @if($lead)
                        <tr>
                          <td>{{$lead->event->name}}</td>
                          <td><a href="{{ route('athlete.show',['athlete'=>$lead->athlete->id]) }}">{{$lead->athlete->first_name}} {{$lead->athlete->last_name}}</a></td>
                          <td><a href="{{ route('competition.show',['competition'=>$lead->competition->id]) }}">{{$lead->mark}}</a></td>
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

          <div class="well" style="margin-top: 20px; ">
            ADVERTISEMENT
          </div>


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
                          <td><a href="{{ route('athlete.show',['athlete'=>$nr->athlete->id]) }}">{{$nr->athlete->first_name}} {{$nr->athlete->last_name}}</a></td>
                          <td><a href="{{ route('competition.show',['competition'=>$nr->competition->id]) }}">{{$nr->mark}}</a></td>
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
                          <td><a href="{{ route('athlete.show',['athlete'=>$nr->athlete->id]) }}">{{$nr->athlete->first_name}} {{$nr->athlete->last_name}}</a></td>
                          <td><a href="{{ route('competition.show',['competition'=>$nr->competition->id]) }}">{{$nr->mark}}</a></td>
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
        
        </div>


        <!-- *****************
        *** 3rd Column ******
        *****************-->
        <div class="col-sm-4">
            <div class="panel panel-1">
              <div class="panel-heading">Facebook Live Feed</div>
              <div class="panel-body">
                <div well="">
                  <img src="https://ps.w.org/custom-facebook-feed/assets/screenshot-3.png?rev=1172284" class="img-responsive center">

                </div>
              </div>
            </div>
            
        </div>

      </div>


    </div>
    <img src="https://image.freepik.com/free-photo/person-running_1112-546.jpg" class="img-responsive center" style="max-width: auto; max-height: auto;">


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
  	          $('.navbar-default').css({"background-color":"rgba(0,0,0,0.1)","transition":"background-color 250ms linear"});
  	       }
  	   });
      }
  });
</script>
@endsection