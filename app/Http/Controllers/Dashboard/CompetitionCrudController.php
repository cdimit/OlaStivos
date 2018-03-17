<?php

namespace App\Http\Controllers\Dashboard;

use App\Competition;
use App\CompetitionSeries;
use App\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CompetitionCrudController extends Controller
{

    private $form_rules = [
      'name' => 'required|string|max:255|min:1',
      'picture' => 'nullable|mimes:jpeg,bmp,png',
      'date_start' => 'nullable|date',
      'date_finish'  => 'nullable|date',
      'country' => 'string',
      'city' => 'string',
      'venue' => 'string|nullable',
      'competition_series' => 'required|array',

      'link_name.*' => 'required|string',
      'link_path.*' => 'required|string',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET all the competitions
        $competitions = Competition::all();

        return view('dashboard.competition.index')->with('competitions',$competitions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $series = CompetitionSeries::pluck('name','id'); //list of series for select field in create form

        return view('dashboard.competition.create')->with('series',$series);;
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
        $this->validate($request, $this->form_rules);

        $competitionDB = Competition::where([
          'name' => $request->name,
          'date_start' => $request->date_start,
          'date_finish' => $request->date_finish,
          'country' => $request->country,
          'city' => $request->city
        ])->get();


        if(!$competitionDB->isEmpty()){
          return redirect()->route('competition.index')->withStatus("Competition already exist!");
        }


        //CREATE new Competition instance
        $competition = new Competition;

        $competition->date_start = $request->date_start;

        if($request->mdays){
          $competition->date_finish = $request->date_finish;
        }else{
          $competition->date_finish = $request->date_start;
        }

        $competition->name = $request->name;
        $competition->country = $request->country;
        $competition->city = $request->city;
        $competition->venue = $request->venue;


        if (!empty($request->picture)) {

            $picture = '/storage/'.$request['picture']->store('pictures/competitions');
        }else{
            $picture = '/img/competition.png';
        }
        $competition->picture = $picture;

        $competition->save();

        //Atach competition series
        $competition->competition_series()->sync($request->competition_series);

        Link::store($competition, $request->link_name, $request->link_path);

        return redirect()->route('competition.index')->withStatus('Competition created successfuly!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $series = CompetitionSeries::pluck('name','id'); //list of series for select field in create form
        $competition_series = CompetitionSeries::all();
        $competition = Competition::find($id);
        return view('dashboard.competition.edit')->with('competition',$competition)->with('series',$series)
                                                ->with('competition_series',$competition_series);
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
        $this->validate($request, $this->form_rules);


        //Get and update Competition instance
        $competition = Competition::find($id);

        $competition->name = $request->name;
        $competition->date_start = $request->date_start;
        $competition->date_finish = $request->date_finish;
        $competition->country = $request->country;
        $competition->city = $request->city;
        $competition->venue = $request->venue;



        if (!empty($request->picture)) {
            if($competition->picture != '/img/competition.png' ){
                Storage::delete(str_replace_first('/storage/', '', $competition->picture));
            }
            $picture = '/storage/'.$request['picture']->store('pictures/competitions');
            $competition->picture = $picture;
        }

        $competition->save();

        //Atach competition series
        $competition->competition_series()->sync($request->competition_series);

        Link::edit($competition, $request->link_name, $request->link_path);

        return redirect()->route('competition.index')->withStatus('Competition updated!');
    }

}
