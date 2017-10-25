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
/*
  background-size: 100% 100%; //stretch resize
*/
}


</style>
@endsection

@section('content')
<div class="divWithBgImage">
</div>

<div class="container">

    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
 			


            	
	        <h3><a href="{{ route('athlete.show',['athlete'=>1]) }}" id="startchange">Athlete Page: {{\App\Athlete::find(1)->first_name}} {{\App\Athlete::find(1)->last_name}}</a>
	        </h3>
	        <h3>
	        <a href="{{ route('competition.show',['competition'=>1]) }}">Competition Page: {{\App\Competition::find(1)->name}}</a>
	        </h3>
          <h3>
          <a href="{{ route('club.show',['club'=>1]) }}">Club Page: {{\App\Club::find(1)->name}}</a>
          </h3>
            
            <img src="https://aff.bstatic.com/images/hotel/840x460/201/2016824.jpg" class="img-responsive center" style="max-width: auto; max-height: auto;">


            <img src="https://aff.bstatic.com/images/hotel/840x460/201/2016824.jpg" class="img-responsive center" style="max-width: auto; max-height: auto;">


       
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