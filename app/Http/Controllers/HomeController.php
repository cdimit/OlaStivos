<?php

namespace App\Http\Controllers;

use \Carbon\Carbon;
use App\Competition;
use App\Athlete;
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

        return view('home')->with('competitions',$competitions)->with('birthdayAthlete',$birthdayAthlete);
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
}
