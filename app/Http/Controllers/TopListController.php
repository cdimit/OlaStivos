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
    $events = Event::outdoor();
    $ages = Age::all();
    $years = Result::years();
    $event = $events->first();


    $results = Result::fromYear(Carbon::now()->year)->where('event_id', $event->id);

    return view('toplist.seasonal')->with('events', $events)
                                   ->with('ages',$ages)
                                   ->with('years',$years)
                                   ->with('results',$results);

  }

  public function search(Request $request)
  {

    //get all events
    if ($request->season != 'All Seasons'){
      $events = Event::where('season',$request->season)->get();
    }else{
      $events = Event::all();
    }

    //EMPTY collections of national records
    $records = collect([]);

    //for each event add the NR in the collection
    foreach($events as $event){
      if($request->category == 'Senior'){
        $records->push($event->getNR());
      }elseif($request->category == 'U23'){
        $records->push($event->getNUR());
      }elseif($request->category == 'Junior'){
          $records->push($event->getNJR());
      }elseif($request->category == 'Youth'){
        $records->push($event->getNYR());
      }


    }


    return view('toplist.seasonal')->with('events',$events)
                  ->with('records',$records)
                  ->with('season',$request->season)
                  ->with('category',$request->category);
  }
}
