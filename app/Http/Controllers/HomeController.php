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
                        ->with('athletesSearch',$athletesSearch);

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
        //Get a random athlete that has birthday
        $athlete = Athlete::whereDay('dob', '=', date('d'))->whereMonth('dob', '=', date('m'))->inRandomOrder()->published()->first();
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
            $res = Result::published()->fromYear(Carbon::now()->year)->where('event_id', $event->id);

            if($event->isField()){
              $results = $res->sortByDesc('mark');
            }else{
              $results = $res->sortBy('mark');
            }
            $leaders->push($results->first());
        }

        return $leaders;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {        
        $athletes = Athlete::search(request('searchInput'))->published()->get()->take(5);
        $competitions = Competition::search(request('searchInput'))->published()->get()->take(5);
        return response()->json([$athletes,$competitions]);

    }

    
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
