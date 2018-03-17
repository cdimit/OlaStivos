<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Age;
use App\Result;
use Carbon\Carbon;

class TopListController extends Controller
{
  public function show()
  {
    //get all events
    // $events = Event::outdoor();
    $ages = Age::all();
    $years = Result::years()->reverse();
    $event = Event::outdoor()->first();


    $res = Result::published()->fromYear(Carbon::now()->year)->where('event_id', $event->id);


    if($event->isField()){
      $results = $res->sortByDesc('mark');
    }else{
      $results = $res->sortBy('mark');
    }

    return view('toplist.seasonal')->with('event', $event)
                                   ->with('ages', $ages)
                                   ->with('years',$years)
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
    $years = Result::years()->reverse();
    $age = Age::find($request->age);

    $res = Result::published()->fromYear($request->year)->where('event_id', $event->id)
                                                ->where('age', '<', $age->max)
                                                ->where('age', '>', $age->min);

    if($event->isField()){
      $results = $res->sortByDesc('mark');
    }else{
      $results = $res->sortBy('mark');
    }

    return view('toplist.seasonal')->with('event', $event)
                                   ->with('years',$years)
                                   ->with('ages', $ages)
                                   ->with('results',$results);


  }

  public function getEvents()
  {

    $age = Age::find(request('age'));
    $results = Result::published()->fromYear(request('year'))->where('age', '<', $age->max)
                                              ->where('age', '>', $age->min);

    $filtered = collect([]);

    foreach($results->unique('event_id') as $result){
      $filtered->push($result->event);
    }

    $events = $filtered->where('gender',request('gender'))->where('season',request('season'));


    return response()->json($events);
  }
}
