
$(document).ready(function(){     
    //Navbar transparent before scrolling down  
    var scroll_start = 0;
    var startchange = $('#startchange');
    var offset = startchange.offset();


    if (startchange.length){
       $(document).scroll(function() { 
          scroll_start = $(this).scrollTop();
          if(scroll_start > offset.top) {
              //$(".navbar-default").css('background-color', 'black');
              $(".navbar-brand").css({'display': 'inline'});
              $(".navbar").addClass("navbar-fixed-top");
              $('.navbar-default').css({ "background": "linear-gradient(to right, white , black)"});

           } else {
              $('.navbar-default').css({"transition":"background-color 600ms linear"});
              $(".navbar-brand").css('display', 'none');
              $(".navbar").removeClass("navbar-fixed-top");

           }
       });
    };


});
