<?php

namespace App\Http\Controllers;

use \Carbon\Carbon;
use App\Competition;
use App\Athlete;
use App\Event;
use App\Result;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Upcoming Competitions
        $competitions = $this->nextComps(10);

        //Athlete with birthday
        $birthdayAthlete = $this->birthdayAthlete();

        //GET National Records
        $maleNRs = $this->getNationalRecords('outdoor','male');
        $femaleNRs = $this->getNationalRecords('outdoor','female');

        //Seasonal Bests Outdoor
        $maleLeaders = $this->getSeasonalLeaders('outdoor','male');
        $femaleLeaders = $this->getSeasonalLeaders('outdoor','female');

        //Countdown Comp
        $countdownComp = $competitions->where('date_start','>',Carbon::now())->shuffle()->first();

        //Count NRs PBs SBs
        
        
        return view('home')->with('competitions',$competitions)
                        ->with('birthdayAthlete',$birthdayAthlete)
                        ->with('maleNRs',$maleNRs)
                        ->with('femaleNRs',$femaleNRs)
                        ->with('maleLeaders',$maleLeaders)
                        ->with('femaleLeaders',$femaleLeaders)
                        ->with('countdownComp',$countdownComp);
    }


        /*
    // Returns next competitions based on date
    // $number: number of competitions returned
    */
    public function nextComps($number)
    {
      $competitions = Competition::where('date_finish', '>=', Carbon::today()->toDateString())->orderBy('date_start')->limit($number)->get();
      return $competitions;
    }


    /*
    // Returns an athlete that has his birthday today in RANDOM
    */
    public function birthdayAthlete()
    {
        //Get a random athlete that has birthday
        $athlete = Athlete::whereDay('dob', '=', date('d'))->whereMonth('dob', '=', date('m'))->inRandomOrder()->first();
        return $athlete;
        
    }


    public function getNationalRecords($season ,$gender){
        
        //get all events
        $events = Event::where('season',$season)->where('gender',$gender)->get();


        //EMPTY collections of national records
        $records = collect([]);
               
        //for each event add the NR in the collection
        foreach($events as $event){
            $records->push($event->getNR());
        }

        return $records;
    }

    public function getSeasonalLeaders($season ,$gender){
        
        //get all events
        $events = Event::where('season',$season)->where('gender',$gender)->get();

        //EMPTY collections of leading results
        $leaders = collect([]);
               
        //for each event add the NR in the collection
        foreach($events as $event){
            $res = Result::fromYear(Carbon::now()->year)->where('event_id', $event->id);
            if($event->isField()){
              $results = $res->sortByDesc('mark');
            }else{
              $results = $res->sortBy('mark');
            }
            $leaders->push($results->first());
        }

        return $leaders;
    }
}
