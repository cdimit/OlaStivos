
$(document).ready(function(){     
    //Navbar transparent before scrolling down  
    var scroll_start = 0;
    var startchange = $('#startchange');
    var offset = startchange.offset();
    // if(scroll_start < offset.top) {
    //   $(".navbar-default").css('background-color', 'black');
    //   $(".navbar-brand").css({'display': 'inline'});
    // }else {
    //   $('.navbar-default').css({"background-color":"rgba(0,0,0,0.1)"});
    //   $(".navbar-brand").css('display', 'none');
    // }
    if (startchange.length){
       $(document).scroll(function() { 
          scroll_start = $(this).scrollTop();
          if(scroll_start > offset.top) {
              //$(".navbar-default").css('background-color', 'black');
              $(".navbar-brand").css({'display': 'inline'});
              $(".navbar").addClass("navbar-fixed-top");
           } else {
              $('.navbar-default').css({"background-color":"rgba(0,0,0,0.8)","transition":"background-color 600ms linear"});
              $(".navbar-brand").css('display', 'none');
              $(".navbar").removeClass("navbar-fixed-top");

           }
       });
    };
    
});
