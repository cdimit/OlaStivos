<?php

namespace App\Http\Controllers;

use App\Athlete;
use \Carbon\Carbon;
use Illuminate\Http\Request;

class AthleteController extends Controller
{
    public function show(Athlete $athlete)
    {

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

        //ACHIEVEMENTS//

        //GET NRs : NR, NUR, NJR, NYR
        $NRs= $athlete->getNRs('NR');
        $NURs= $athlete->getNRs('NUR');
        $NJRs= $athlete->getNRs('NJR');
        $NYRs= $athlete->getNRs('NYR');


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
        						->with('chartsResults',$chartsResults);
        
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
}
