<?php

namespace App\Http\Controllers\Dashboard;

use App\Result;
use App\Athlete;
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
        $result = new Result;

        $result->position = $request->position;
        $result->athlete_id = $request->athlete_id;
        $result->event_id = $request->event_id;
        $result->competition_id = $request->competition_id;
        $result->mark = $request->mark;
        $result->wind = $request->wind;
        $result->date = $request->date;
        $result->race = $request->race;
        $result->score = $request->score;

        //
        //Find and store age category
        //
        // 1. Get athlete DOB
        $athlete = Athlete::find($request->athlete_id);
        // 2. Find difference between DOB and result date
        $date = new \DateTime($request->date);
        $difference = $date->diff(new \DateTime($athlete->dob));
        // 3. Save age category in years format to result record
        $result->age = $difference->format('%y');


        $result->save();

        //Attach all records made
        // if ($request->records){
        //     foreach($request->records as $record){
        //         //atach result with record and event
        //         $result->records()->attach($record, ['event_id' => $request->event_id]);
        //     }
        // }

        $athlete->setRecordIfExist($result);

        // if(!$athlete->setPbIfExist($result)){
        //   $athlete->setSbIfExist()
        // }



        return redirect()->route('result.index');
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
        $records = Record::all();

        //all the records achieved in this result
        $resultRecords = $result->records()->get();

        //put record_ids in a collection
        //this helps in the edit form
        $achievements = collect([]);
        foreach($resultRecords as $record){
            $achievements->push($record->id);
        }

        return view('dashboard.result.edit')->with('result',$result)->with('athletes',$athletes)->with('events',$events)->with('competitions',$competitions)->with('records',$records)->with('achievements',$achievements);
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
            'athlete_id' => 'required|integer',
            'event_id' => 'required|integer',
            'competition_id' => 'required|integer',
            'mark' => 'required|string',
            'date'  => 'date',
            'race' => 'string|nullable',
            'score' => 'integer|nullable',
        ]);

        //CREATE new Result instance
        $result = Result::find($id);

        $result->position = $request->position;
        $result->athlete_id = $request->athlete_id;
        $result->event_id = $request->event_id;
        $result->competition_id = $request->competition_id;
        $result->mark = $request->mark;
        $result->wind = $request->wind;
        $result->date = $request->date;
        $result->race = $request->race;
        $result->score = $request->score;

        //
        //Find and store age category
        //
        // 1. Get athlete DOB
        $athlete = Athlete::find($request->athlete_id);
        $athlete_dob = $athlete->dob;
        // 2. Find difference between DOB and result date
        $date = new \DateTime($request->date);
        $difference = $date->diff(new \DateTime($athlete->dob));
        // 3. Save age category in years format to result record
        $result->age = $difference->format('%y');


        $result->save();

        //
        //EDIT Records
        //
        // 1. Detach all records from result
        $resultRecords = $result->records()->detach();
        // 2. Add new record if they exist
        if($request->records){
            foreach($request->records as $record){
                //atach result with record and event
                $result->records()->attach($record, ['event_id' => $request->event_id]  );
            }
        }
        return redirect()->route('result.index');
    }

}
