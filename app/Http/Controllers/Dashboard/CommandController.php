<?php

namespace App\Http\Controllers\Dashboard;

use App\Athlete;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Result;

class CommandController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $events = Event::all();

        return view('dashboard.commands.index')->withEvents($events);
    }

    /**
     * Fix year collumn in athletes that only have DOB
     *
     * @return \Illuminate\Http\Response
     */
    public function fixYearInAthletes($athletes = null)
    {
    	// Touto en se periptwsi pou theloume na perasoume sigkekrimenous athlites sto mellon
    	if($athletes === null){
   			$athletes = Athlete::where('dob','!=',null)->get();
    	}

   		foreach ($athletes as $athlete) {
        	$athlete->year = (new \DateTime($athlete->dob))->format('Y');
        	$athlete->save();
   		}
        return redirect()->route('commands.index')->withStatus("Athletes Year Collumn updated!");
    }

    public function refreshRecordByEvent()
    {

      $eventId = request()->event;

      if($eventId=="all"){
        $events = Event::all();
        foreach($events as $event){
          $event->refreshRecords();
        }
      }else{
        $event = Event::find($eventId);

        $event->refreshRecords();
      }


      return redirect()->route('commands.index')->withStatus("Event Records was updated!");
    }

    public function fixAgeInResults()
    {
      $results = Result::all();

      foreach($results as $result){
        //
        //Find and store age category
        //
        // 1. Get athlete DOB
        $athlete = Athlete::find($result->athlete->id);
        // 2. Find difference between DOB and result date YEAR
        $result_year = (new \DateTime($result->date))->format('Y');//year of result
        $dob_year = $athlete->year;//year of birth
        $difference = $result_year-$dob_year;
        // 3. Save age category in years format to result record
        $result->age = $difference;

        $result->save();
      }

      return redirect()->route('commands.index')->withStatus("Age Column for Result was updated!");

    }

}
