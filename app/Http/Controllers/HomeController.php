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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Upcoming Competitions
        $competitions = $this->nextComps(5);

        $todayComp = Competition::where('date_start','>=',Carbon::today())
                                ->where('date_finish','<=',Carbon::today())
                                ->first();

        //Athlete with birthday
        $birthdayAthlete = $this->birthdayAthlete();

        //GET National Records
        $maleNRs = $this->getNationalRecords('outdoor','male');
        $femaleNRs = $this->getNationalRecords('outdoor','female');

        //Seasonal Bests Outdoor
        $maleLeaders = $this->getSeasonalLeaders('indoor','male');
        $femaleLeaders = $this->getSeasonalLeaders('indoor','female');

        //Countdown Comp
        $countdownComp = $competitions->where('date_start','>',Carbon::now())->shuffle()->first();

        //Data for Search
        $athletesSearch = Athlete::all()->sortBy('first_name');
        $competitionsSearch = Competition::all();

        return view('home')->with('competitions',$competitions)
                        ->with('birthdayAthlete',$birthdayAthlete)
                        ->with('maleNRs',$maleNRs)
                        ->with('femaleNRs',$femaleNRs)
                        ->with('maleLeaders',$maleLeaders)
                        ->with('femaleLeaders',$femaleLeaders)
                        ->with('countdownComp',$countdownComp)
                        ->with('competitionsSearch',$competitionsSearch)
                        ->with('athletesSearch',$athletesSearch)
                        ->with('todayComp',$todayComp);

    }


        /*
    // Returns next competitions based on date
    // $number: number of competitions returned
    */
    public function nextComps($number)
    {
      $competitions = Competition::published()->where('date_finish', '>=', Carbon::today()->toDateString())->get()->sortBy('date_start')->take($number);
      return $competitions;
    }


    /*
    // Returns an athlete that has his birthday today in RANDOM
    */
    public function birthdayAthlete()
    {
        //Get a shiffled collection of athletes that have their birthday today
        $athletes = Athlete::whereDay('dob', '=', date('d'))->whereMonth('dob', '=', date('m'))->inRandomOrder()->published()->get()->shuffle();
        //Check one by one if they are active over the last year
        // If yes then show their birthday
        if($athletes->first()){
            foreach ($athletes as $athlete) {
                $last_result = $athlete->results->sortByDesc('date')->first();
                $now = Carbon::now();
                if($now->diffInMonths(Carbon::parse($last_result->date)) < 24){
                    return $athlete;
                }
            }
        }
        return null;
    }


    public function getNationalRecords($season ,$gender){

        //get all events
        $events = Event::where('season',$season)->where('gender',$gender)->orderBy('order')->get();


        //EMPTY collections of national records
        $records = collect([]);

        //for each event add the NR in the collection
        foreach($events as $event){
            if($event->getNR()->first()){
                //get event NR and set attribute order based on event
                $record = $event->getNR();//->setAttribute('order', $event->order);
                $records->push($record);
            }
        }

        //sort records based of event order attribute
        return $records;//->sortBy('order');
    }

    public function getSeasonalLeaders($season ,$gender){

        //get all events
        $events = Event::where('season',$season)->where('gender',$gender)->orderBy('order')->get();

        //EMPTY collections of leading results
        $leaders = collect([]);
        //for each event add the NR in the collection
        foreach($events as $event){
            $res = Result::published()->fromYear(Carbon::now()->year)->where('event_id', $event->id)->where('is_recordable', true);

            if($event->isField()){
              $results = $res->sortByDesc('mark');
            }else{
              $results = $res->sortBy('mark');
            }

            if($results->first()){
                $leader = $results->first();

                $sameLeader = $results->where('mark','=',$leader['mark']);

                $leaders->push($sameLeader);
            }
        }

        return $leaders;
    }


    /**
     * Search function p stelnei apotelesmata sto navbar avtomata
     */
    public function search()
    {
        $athletes = Athlete::search(request('searchInput'))->published()->get()->take(5);
        $competitions = Competition::search(request('searchInput'))->published()->get()->take(5);
        return response()->json([$athletes,$competitions]);

    }

    // Search function otan patiseis enter sto navbar i otan eisai sto search page
    public function searchShow(Request $request)
    {
        if($request->type == 'athletes'){
            $athletes = Athlete::search($request->searchQuery)->published()->get();
            $competitions = collect();
        }elseif($request->type == 'competitions'){
            $competitions = Competition::search($request->searchQuery)->published()->get();
            $athletes = collect();
        }else{
            $athletes = Athlete::search($request->searchQuery)->published()->get();
            $competitions = Competition::search($request->searchQuery)->published()->get();
        }

        return view('search.search_page')->with('competitions',$competitions)
                                        ->with('athletes',$athletes);

    }


}
