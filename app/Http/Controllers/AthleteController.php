<?php

namespace App\Http\Controllers;

use App\Athlete;
use App\Result;
use App\Event;
use \Carbon\Carbon;
use Illuminate\Http\Request;

class AthleteController extends Controller
{
    public function show(Athlete $athlete)
    {

        if(!$athlete->status){
          abort(404);
        }

        //Get best PBs and SBs
        $pbs= $athlete->getPbs();
        $sbs = $athlete->getSbs(\Carbon\Carbon::now()->year);

        //Get all results of athlete
        //$results:	KEYS: event_id VALUES: collection of results for the key event
        $results = $athlete->getAllResultsByEvent();
        $chartsResults = $this->chartData($results);

        $results = $athlete->results->sortByDesc('date')->groupBy(function($attributes) {
                return Carbon::parse($attributes->date)->format('Y'); // grouping by years
            });

        //Get all Personal Bests of athlete all over the years
        //$allPbs:	KEYS: event_id VALUES: collection of PBs made for the key event
        $allPbs = $athlete->getAllPbs();
		$chartsPbs = $this->chartData($allPbs);

        //History of SBs
        $sbHistory = $this->getSBHistory($athlete);

        //ACHIEVEMENTS//

        //GET NRs : NR, NUR, NJR, NYR
        $NRs= $athlete->getNRs('NR');
        $NURs= $athlete->getNRs('NUR');
        $NJRs= $athlete->getNRs('NJR');
        $NYRs= $athlete->getNRs('NYR');

        $NRs= $this->athleteCurrentNRs($athlete,'NR');
        $NURs= $this->athleteCurrentNRs($athlete,'NUR');
        $NJRs= $this->athleteCurrentNRs($athlete,'NJR');
        $NYRs= $this->athleteCurrentNRs($athlete,'NYR');

        //GET National competition wins
        $nwins = $athlete->countPlaces(\App\CompetitionSeries::find('1'),'1');

        return view('athlete.show')->with('athlete',$athlete)
        						->with('pbs',$pbs)
        						->with('sbs',$sbs)
        						->with('results',$results)
        						->with('allPbs',$allPbs)
        						->with('NRs',$NRs)
        						->with('NURs',$NURs)
        						->with('NJRs',$NJRs)
        						->with('NYRs',$NYRs)
        						->with('nwins',$nwins)
        						->with('chartsPbs',$chartsPbs)
        						->with('chartsResults',$chartsResults)
                                ->with('sbHistory',$sbHistory);

    }


    public function chartData($results)
    {
        $charts=collect([]);
        foreach($results as $event => $eventResults){
        	$array=collect([]);
     		foreach ($eventResults as $key => $value) {
     			$array->put($value->date, $value->mark);
     		}
     		$charts->put($event,$array);
        }
        return $charts->toArray();
    }

    public function getSBHistory($athlete)
    {
        $sbHistory=collect([]);

        //all results of athlete
        $results = $athlete->results;

        //unique events participated
        $events = $athlete->uniqueEvents($results);
        //results grouped by year
        $results = $results->sortBy('date')->groupBy(function($attributes) {
                return Carbon::parse($attributes->date)->format('Y'); // grouping by years
            });

        //create sbHistory collection, grouped in years and events
        foreach ($results->keys() as $year) {
            $sbsOfYear= collect([]);
            foreach ($events as $event) {
                $sbOfEvent = $athlete->getSB($year, Event::find($event));
                $sbsOfYear->put($event,$sbOfEvent);
            }
            $sbHistory->put($year,$sbsOfYear);
        }
        return $sbHistory;
    }

    public function athleteCurrentNRs(Athlete $athlete,$acronym = "NR")
    {
                
        //Get all NR records of the athlete
        $NRs= $athlete->getNRs($acronym);

        $collection=collect([]);
        foreach($NRs as $eventID=>$NR){
            //event of NR
            $event = Event::find($eventID);
            switch ($acronym) {
                case 'NR':
                    $eventNR = $event->getNR();
                    break;
                case 'NYR':
                    $eventNR = $event->getNYR();
                    break;
                case 'NUR':
                    $eventNR = $event->getNUR();
                    break;
                case 'NJR':
                    $eventNR = $event->getNJR();
                    break;
                default:
                    $eventNR = $event->getNR();
                    break;
            }
            
            if($eventNR == $NR){
                $collection = $collection->put($eventID, $NR);
            }      
        }
        return $collection;
    }
}
