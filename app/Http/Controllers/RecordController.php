<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class RecordController extends Controller
{
    public function showNRs()
    {
    	//get all events
    	$events = Event::all();
    	
    	//EMPTY collections of national records
    	$records = collect([]);
    	
    	//for each event add the NR in the collection
    	foreach($events as $event){
    		$records->push($event->getNR());
    	}
    	
    	
    	return view('record.nationals')->with('events',$events)
    								->with('records',$records)
    								->with('season','All Seasons')
    								->with('category','Senior');
    }

    public function searchNRs(Request $request)
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
    	
    	
    	return view('record.nationals')->with('events',$events)
    								->with('records',$records)
    								->with('season',$request->season)
    								->with('category',$request->category);
    }



}