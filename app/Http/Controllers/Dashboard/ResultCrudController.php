<?php

namespace App\Http\Controllers\Dashboard;

use Auth;
use App\Result;
use App\Athlete;
use App\Age;
use App\Event;
use App\Competition;
use App\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Result::all();

        return view('dashboard.result.index')->with('results',$results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $athletes = Athlete::all();
        $events = Event::all();
        $competitions = Competition::all();
        $records = Record::all();

        return view('dashboard.result.create')->with('athletes',$athletes)->with('events',$events)->with('competitions',$competitions)->with('records',$records);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //VALIDATE DATA
        $this->validate($request, [
            'position' => 'required|string|max:3|min:1',
            'overall' => 'nullable|string|max:3|min:1',
            'athlete_id' => 'required|integer',
            'event_id' => 'required|integer',
            'competition_id' => 'required|integer',
            'wind' => 'numeric|nullable',
            'date'  => 'date',
            'race' => 'string|nullable',
            'score' => 'integer|nullable',

            'meters' => 'integer|nullable',
            'cmeters' => 'integer|nullable|max:99',
            'hours' => 'integer|nullable',
            'minutes' => 'integer|nullable|max:59',
            'seconds' => 'integer|nullable|max:59',
            'decimal' => 'integer|nullable|max:99'
        ]);

        if($request->type=="relay"){
          $resultDB = Result::where([
            'athlete_id' => $request->team_id,
            'event_id' => $request->event_id,
            'competition_id' => $request->competition_id,
            'race' => $request->race
          ])->get();
        }else{
          $resultDB = Result::where([
            'athlete_id' => $request->athlete_id,
            'event_id' => $request->event_id,
            'competition_id' => $request->competition_id,
            'race' => $request->race
          ])->get();
        }

        if(!$resultDB->isEmpty()){
          return redirect()->route('result.index')->withStatus("Result is already exist!");
        }

        //CREATE new Result instance
        $result = new Result;

        $result->position = $request->position;
        $result->overall = $request->overall;

        if($request->type=="relay"){
          $result->athlete_id = $request->team_id;
        }else{
          $result->athlete_id = $request->athlete_id;
        }

        $result->event_id = $request->event_id;
        $result->competition_id = $request->competition_id;
        $result->wind = $request->wind;
        $result->date = $request->date;
        $result->race = $request->race;
        $result->score = $request->score;

        if($request->handed){
          $decimal = $request->decimal."H";
        }else{
          $decimal = $request->decimal;
        }


        //Save mark based on event type
        if($request->type=="field"){
          $result->mark = $this->createFieldMark($request->meters,$request->cmeters);
        }else{
          $result->mark = $this->createTrackMark($request->hours,$request->minutes,$request->seconds,$decimal);
        }

        if(!$request->recordable || $result->wind > 2 || $result->event->season=="cross country"){
          $result->is_recordable = false;
        }


        if($request->type=="relay"){
          foreach($request->relay_id as $rel){
            $data = explode(" ",$rel);
            $years[] = $data[1];
            $ids[] = $data[0];
          }
          $older_athlete = min($years);
        }else{
          $athlete = Athlete::find($request->athlete_id);

          $older_athlete = $athlete->year;//year of birth

        }


        //
        //Find and store age category
        $result_year = (new \DateTime($request->date))->format('Y');//year of result
        $difference = $result_year-$older_athlete;
        // 3. Save age category in years format to result record

        if($request->type=='relay' && Age::isU23($difference)){
          $younger_athlete = max($years);
          if(Age::isU23($result_year-$younger_athlete)){
            $age=$difference;
          }else{
            $age = 100;
          }
        }else{
          $age = $difference;
        }


        $result->age = $age;

        $result->save();


        if($request->type=="relay"){
          foreach($ids as $id){
            $result->relayAthletes()->attach([$id]);
          }
        }

        // $athlete->setRecordIfExist($result);

        // if(!$athlete->setPbIfExist($result)){
        //   $athlete->setSbIfExist()
        // }



        return redirect()->route('result.index')->withStatus('Result stored!');
      }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result=Result::find($id);
        $athletes = Athlete::all();
        $events = Event::all();
        $competitions = Competition::all();

        return view('dashboard.result.edit')->with('result',$result)
                                            ->with('athletes',$athletes)
                                            ->with('events',$events)
                                            ->with('competitions',$competitions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //VALIDATE DATA
        $this->validate($request, [
            'position' => 'required|string|max:3|min:1',
            'overall' => 'nullable|string|max:3|min:1',
            'athlete_id' => 'required|integer',
            'event_id' => 'required|integer',
            'competition_id' => 'required|integer',
            'mark' => 'required|string',
            'wind' => 'numeric|nullable',
            'date'  => 'date',
            'race' => 'string|nullable',
            'score' => 'integer|nullable',
        ]);

        //CREATE new Result instance
        $result = Result::find($id);

        $result->position = $request->position;
        $result->overall = $request->overall;
        $result->athlete_id = $request->athlete_id;
        $result->event_id = $request->event_id;
        $result->competition_id = $request->competition_id;
        $result->mark = $request->mark;
        $result->wind = $request->wind;
        $result->date = $request->date;
        $result->race = $request->race;
        $result->score = $request->score;

        if(!$request->recordable || $result->wind > 2 || $result->event->season=="cross country"){
          $result->is_recordable = false;
          $result->records()->detach();
        }else{
          $result->is_recordable = true;
        }


        if($request->type=="relay"){
          foreach($request->relay_id as $rel){
            $data = explode(" ",$rel);
            $years[] = $data[1];
            $ids[] = $data[0];
          }
          $older_athlete = min($years);
        }else{
          $athlete = Athlete::find($request->athlete_id);

          $older_athlete = $athlete->year;//year of birth

        }

        //
        //Find and store age category
        //
        // 1. Get athlete DOB
        // 2. Find difference between DOB and result date YEAR
        $result_year = (new \DateTime($request->date))->format('Y');//year of result
        $difference = $result_year-$older_athlete;
        // 3. Save age category in years format to result record

        if($request->type=="relay" && Age::isU23($difference)){
          $younger_athlete = max($years);
          if(Age::isU23($result_year-$younger_athlete)){
            $age=$difference;
          }else{
            $age = 100;
          }
        }else{
          $age = $difference;
        }

        $result->age = $age;



        $result->save();

        if($request->type=="relay"){
          $result->relayAthletes()->detach();
          foreach($ids as $id){
            $result->relayAthletes()->attach([$id]);
          }
        }


        $result->event->refreshRecords($result->date);

        // //
        // //EDIT Records
        // //
        // // 1. Detach all records from result
        // $resultRecords = $result->records()->detach();
        // // 2. Add new record if they exist
        // if($request->records){
        //     foreach($request->records as $record){
        //         //atach result with record and event
        //         $result->records()->attach($record, ['event_id' => $request->event_id]  );
        //     }
        // }
        return redirect()->route('result.index')->withStatus('Result updated!');
    }


    public function destroy($id)
    {
      $this->authorize('delete', Result::class);
      $result=Result::find($id);
      $event = $result->event;
      $result->records()->detach();

      $result->delete();

      $event->refreshRecords($result->date);

      return redirect()->route('result.index');

    }

    /**
     * Show the form for creating a new Race.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRace()
    {

        $athletes = Athlete::all();
        $events = Event::all();
        $competitions = Competition::all();
        $records = Record::all();

        return view('dashboard.result.create_race')->with('athletes',$athletes)->with('events',$events)->with('competitions',$competitions)->with('records',$records);
    }

    /**
     * Store a race created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRace(Request $request)
    {
        //VALIDATE DATA
        $this->validate($request, [
            'positions' => 'required|array|min:1',
            'position.*' => 'required|string',
            'athlete_ids' => 'required|array|min:1',
            'athlete_ids.*' => 'required|integer',
            'scores'=>'required|array|min:1',
            'scores.*' => 'nullable|integer',

            'event_id' => 'required|integer',
            'competition_id' => 'required|integer',
            'wind' => 'numeric|nullable',
            'date'  => 'date',
            'race' => 'string|nullable',

            // 'meters' => 'array',
            // 'meters.*' => 'integer|nullable',
            // 'cmeters' => 'array',
            // 'cmeters.*' => 'integer|nullable|max:99',
            // 'hours' => 'array',
            // 'hours.*' => 'integer|nullable',
            // 'minutes' => 'array',
            // 'minutes.*' => 'integer|nullable|max:59',
            // 'seconds' => 'array',
            // 'seconds.*' => 'integer|nullable|max:59',
            // 'decimal' => 'array',
            // 'decimal.*' => 'integer|nullable|max:99'
        ]);

        foreach ($request->positions as $key => $value)  {
            // $key = 0,1,2,3.... , $value= Position of Athlete

            //CREATE new Result instance
            $result = new Result;

            $result->position = $value;
            $result->overall = $request->overall[$key];
            $result->athlete_id = $request->athlete_ids[$key];
            $result->score = $request->scores[$key];

            $result->event_id = $request->event_id;
            $result->competition_id = $request->competition_id;
            $result->wind = $request->wind;
            $result->date = $request->date;
            $result->race = $request->race;

            if(!$request->recordable || $result->wind > 2 || $result->event->season=="cross country"){
              $result->is_recordable = false;
              $result->records()->detach();
            }else{
              $result->is_recordable = true;
            }

            //Store mark based on event
            if($request->type=="field"){
              $result->mark = $this->createFieldMark($request->meters[$key],$request->cmeters[$key]);
            }else{
              $result->mark = $this->createTrackMark($request->hours[$key],$request->minutes[$key],$request->seconds[$key],$request->decimal[$key]);
            }



            //
            //Find and store age category
            //
            // 1. Get athlete DOB
            $athlete = Athlete::find($request->athlete_ids[$key]);
            // 2. Find difference between DOB and result date YEAR
            $result_year = (new \DateTime($request->date))->format('Y');//year of result
            $dob_year = (new \DateTime($athlete->dob))->format('Y');//year of birth
            $difference = $result_year-$dob_year;
            // 3. Save age category in years format to result record
            $result->age = $difference;


            $result->save();

        }

        return redirect()->route('result.index');
      }


        public function getEvents()
        {

          $events = Event::where('type', request('type'))->get();



          return response()->json($events);
        }

        public function getDates()
        {

          $competition = Competition::find(request('competition'));

          $begin = new \DateTime($competition->date_start);

          $end = new \DateTime(Carbon::parse($competition->date_finish)->addDay());

          $daterange = new \DatePeriod($begin, new \DateInterval('P1D'), $end);

          $dates = collect([]);

          foreach($daterange as $date){
              $dates->push($date->format("Y-m-d"));
          }


          return response()->json($dates);
        }


        public function createFieldMark($meters,$cmeters){
          return ($meters ? $meters : '00').'.'.$this->generateMarkString($cmeters);
        }

        public function createTrackMark($hours,$minutes,$seconds,$decimal){
          return $this->generateMarkString($hours).':'.$this->generateMarkString($minutes).':'.$this->generateMarkString($seconds).'.'.$this->generateMarkString($decimal);
        }

        public function generateMarkString($str){
          if(strlen($str)>=2){
            return $str;
          }elseif ( strlen($str)===1 ) {
            return '0'.$str;
          }else{
            return '00';
          }

        }

}
