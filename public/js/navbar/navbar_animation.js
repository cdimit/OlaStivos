
$(document).ready(function(){     
    //Navbar transparent before scrolling down  
    var scroll_start = 0;
    var startchange = $('#startchange');
    var offset = startchange.offset();

    if (startchange.length){
       $(document).scroll(function() { 
          scroll_start = $(this).scrollTop();
          if(scroll_start > offset.top) {
              $(".navbar-default").css('background-color', 'black');
              $(".navbar-brand").css({'display': 'inline'});
           } else {
              $('.navbar-default').css({"background-color":"rgba(0,0,0,0.1)","transition":"background-color 250ms linear"});
              $(".navbar-brand").css('display', 'none');
           }
       });
    };
    
});
