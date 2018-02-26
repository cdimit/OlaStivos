<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Age;
use App\Result;
use Carbon\Carbon;

class ScoreListController extends Controller
{
  public function show()
  {
    //get all events
    // $events = Event::outdoor();
    $ages = Age::all();
    $years = Result::years()->reverse();
    $event = Event::outdoor()->first();
    $selected = collect([]);
    $selected->push(null)->push(null)->push(null)->push(null)->push(null);


    $res = Result::published()->fromYear(Carbon::now()->year)->where('event_id', $event->id);


    if($event->isField()){
      $results = $res->sortByDesc('mark');
    }else{
      $results = $res->sortBy('mark');
    }

    return view('scorelist.scorelist')->with('selected', $selected)
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


    if($request->event=="all"){
      $group = Event::where('season', $request->season)->get();
    }else{
      $group = Event::where('type', $request->event)->where('season', $request->season)->get();
    }

    if($request->gender!="all"){
      $event_group = $group->where('gender', $request->gender);
    }

    $ages = Age::all();
    $years = Result::years()->reverse();
    $age = Age::find($request->age);


      if($request->year=='all'){
        $res = Result::published()->where('score', '<>', null)
                                                            ->where('age', '<', $age->max)
                                                            ->where('age', '>', $age->min)->get();
      }else{
        $res = Result::published()->fromYear($request->year)
                                                          ->where('score', '<>', null)
                                                            ->where('age', '<', $age->max)
                                                            ->where('age', '>', $age->min);
      }

$events_id = $event_group->pluck('id');

$results = $res->whereIn('event_id', $events_id)->sortByDesc('score');

$selected = collect([]);
$selected->push($request->year)->push($request->age)->push($request->season)->push($request->gender)->push($request->event);


    return view('scorelist.scorelist')->with('selected', $selected)
                                    ->with('years',$years)
                                   ->with('ages', $ages)
                                   ->with('results',$results);


  }

}
