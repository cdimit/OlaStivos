@extends('layouts.app')

@section('styles')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

<style type="text/css">
    h1{
        color: white;
        font-weight: bold;
        margin-top: 40px;
        margin-bottom: 20px; 
        text-shadow: -0.5px 0 black, 0 0.5px black, 0.5px 0 black, 0 -0.5px black;
    }
    .image-back {
        background: url(https://static1.squarespace.com/static/586cf745d2b85773859477d2/58bfe2b217bffc3b2fcf9bcd/58c27cb2a5790ae22306e6f9/1491474923990/banner11.png) no-repeat center;
        background-size:100%;
        min-height: 150px;
        margin-top: 51px;
        margin-bottom: 10px;
    }
</style>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="col-md-12 image-back">
                <h1>Ημερολόγιο Αγώνων</h1>
            </div>    
            <div id='calendar'></div>

        </div>
    </div>
</div>
@endsection



@section('scripts')
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            header: {
                center: 'prev,next today',
                right: 'month,listMonth,listYear,'
            },
            views: {
                month: {
                    buttonText: 'Ημερολόγιο'
                },
                listYear: {
                    buttonText: 'Χρονιά'
                },
                listMonth:{
                    buttonText: 'Μήνας'
                }
            },
            events : [
                @foreach($competitions as $competition)
                {
                    title : '{{ $competition->name }}',
                    start : '{{ $competition->date_start }}',
                    end : '{{ $competition->date_finish }}',
                    url : '{{ route('competition.show', $competition->id) }}'
                },
                @endforeach
            ]
        })
    });
</script>
@endsection