$(document).ready(function() {
    $('#searchPanel').hide();
    $(document).click(function () { 
        if ($('#searchPanel').is(":visible")){
            $('#searchPanel').fadeOut(100);
        }
    });

    // $('#searchInput').keypress(function(e){

    // });

    $('#searchInput').unbind('keypress').bind('keypress',function(e){

        var myUrl = '/search';
        var myData = {
            searchInput: $('#searchInput').val(),
        };
        
        if(e.which == 13){//Enter key pressed
            $("#searchButton").click();
        }else{
            $('#resultsSearchAthletes').empty();
            $('#resultsSearchCompetitions').empty();
            axios.post(myUrl, myData ).then(function (response) {
                $('#resultsSearchAthletes').empty();
                $('#resultsSearchCompetitions').empty();
                //$('#resultsSearchAthletes').append('<h5 style="margin-bottom:0; margin-top:0;">Αθλητές:</h5>');
                $.each(response.data[0], function( index, value ) {
                $('#resultsSearchAthletes').append($("<li>",{})).append($("<a>", {
                    href: '/athlete/'+value.id,
                    value: value.id,
                    text: value.first_name+' '+value.last_name+' '+value.dob,
                    }));  
                });
                if(response.data[0] == 0){
                    $('#resultsSearchAthletes').append('<h6>Δεν βρέθηκαν αθλητές</h6>');
                }

                //$('#resultsSearch').append('<hr style="margin:0;">');
                //$('#resultsSearchCompetitions').append('<h5 style="margin-bottom:0; margin-top:0;">Αγώνες:</h5>');
                $.each(response.data[1], function( index, value ) {
                    $('#resultsSearchCompetitions').append($("<li>",{})).append($("<a>", {
                        href: '/competition/'+value.id,
                        value: value.id,
                        text: value.name+' '+value.date_start,
                    }));  
                });

                if(response.data[1].length == 0){
                    $('#resultsSearchCompetitions').append('<h6>Δεν βρέθηκαν αγώνες</h6>');
                }

            })
            .catch(function (error) {
                console.log('error');
            });
            $('#searchPanel').fadeIn(200);
        }
    }); 
});
