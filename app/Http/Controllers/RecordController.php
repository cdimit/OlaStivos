<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class RecordController extends Controller
{
    public function showNRs()
    {
    	//get all events
    	$events = Event::where('season','outdoor')->where('gender','male')->get();
    	
    	//EMPTY collections of national records
    	$records = collect([]);
    	
    	//for each event add the NR in the collection
    	foreach($events as $event){
    		$records->push($event->getNR());
    	}

    	
    	return view('record.nationals')->with('events',$events)
    								->with('records',$records)
    								->with('season','Outdoor')
    								->with('category','Senior');
    }

    public function searchNRs(Request $request)
    {	

    	//get all events
        $events = Event::where('season',$request->season)->where('gender',$request->gender)->get();


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

    public function showNRsHistory()
    {
        return view('record.nationals_history')->with('event',null)
                                            ->with('records',null)
                                            ->with('season',null)
                                            ->with('category',null);
    }


    public function searchNRsHistory(Request $request)
    {   

        //get event
        $event = Event::find($request->event);

        if($request->category == 'Senior'){
            $records = $event->getAllRecords('NR'); 
        }elseif($request->category == 'U23'){
            $records = $event->getAllRecords('NUR');
        }elseif($request->category == 'Junior'){
            $records = $event->getAllRecords('NJR');
        }elseif($request->category == 'Youth'){
            $records = $event->getAllRecords('NYR');
        }

        
        return view('record.nationals_history')->with('event',$event)
                                    ->with('records',$records)
                                    ->with('season',$request->season)
                                    ->with('category',$request->category);
    }


    public function getEvents()
    {
        $events = Event::where('gender',request('gender'))->where('season',request('season'))->get();

        return response()->json($events);
    }


}