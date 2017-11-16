<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Age;
use App\Result;
use Carbon\Carbon;

class AllTimeController extends Controller
{
  public function show()
  {
    //get all events
    // $events = Event::outdoor();
    $ages = Age::all();
    $event = Event::outdoor()->first();


    $res = Result::published()->where('event_id', $event->id)->get();

    if($event->isField()){
      $results = $res->sortByDesc('mark');
    }else{
      $results = $res->sortBy('mark');
    }


    return view('alltime.best_by_event')->with('event', $event)
                                   ->with('ages', $ages)
                                   ->with('results',$results);

  }

  public function search(Request $request)
  {

    //year
    //age
    //season(indoor, outdoor)
    //gender
    //event


    $event = Event::find($request->event);
    $ages = Age::all();
    $age = Age::find($request->age);

    $res = Result::published()->where('event_id', $event->id)
                  ->where('age', '<', $age->max)
                  ->where('age', '>', $age->min)->get();

    if($event->isField()){
      $results = $res->sortByDesc('mark');
    }else{
      $results = $res->sortBy('mark');
    }

    return view('alltime.best_by_event')->with('event', $event)
                                   ->with('ages', $ages)
                                   ->with('results',$results);


  }

  public function getEvents()
  {

    $age = Age::find(request('age'));
    $results = Result::published()->where('age', '<', $age->max)
                      ->where('age', '>', $age->min)->get();

    $filtered = collect([]);

    foreach($results->unique('event_id') as $result){
      $filtered->push($result->event);
    }

    $events = $filtered->where('gender',request('gender'))->where('season',request('season'));


    return response()->json($events);
  }
}
