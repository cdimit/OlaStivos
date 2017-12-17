<?php

namespace App\Http\Controllers\Dashboard;

use App\Athlete;
use App\Result;
use App\Competition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PendingController extends Controller
{
    public function index()
    {
    	$athletes = Athlete::pending()->get();
    	$competitions = Competition::pending()->get();
    	$results = Result::pending()->get();

    	return view('dashboard.pending.index')->with('athletes',$athletes)
        						->with('competitions',$competitions)
        						->with('results',$results);
    }

    public function publish(Request $request)
    {
    	if($request->athletes){
    		$this->publishAthletes($request->athletes);
    	}

    	if($request->competitions){
    		$this->publishCompetitions($request->competitions);
    	}

    	if($request->results){
    		$this->publishResults($request->results);
    	}

    	return redirect()->route('pending.index');
    }

    //Publish Functions
    public function publishAthletes($athletes)
    {
    	foreach ($athletes as $athlete_id) {
    		$athlete= Athlete::find($athlete_id);
			$athlete->status = 1;
			$athlete->save();
    	}
    	return;
    }

    public function publishCompetitions($competitions)
    {
		foreach ($competitions as $competition_id) {
    		$competition= Competition::find($competition_id);
			$competition->status = 1;
			$competition->save();
    	}
    	return;
    }

    public function publishResults($results)
    {

		foreach ($results as $result_id) {
    		$result= Result::find($result_id);
    		//To publish the result, the athlete and competition should have been published
  			if($result->athlete->isPublished() && $result->competition->isPublished()){
  				$result->status = 1;
  				$result->save();

  				//Attach Records
          if($result->is_recordable){
            // $result->athlete->setRecordIfExist($result);
            $result->event->refreshRecords($result->date);

          }
  			}
    	}
    	return;
    }
}
