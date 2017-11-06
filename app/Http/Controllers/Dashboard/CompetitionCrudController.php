<?php

namespace App\Http\Controllers\Dashboard;

use App\Competition;
use App\CompetitionSeries;
use App\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetitionCrudController extends Controller
{

    private $form_rules = [
      'name' => 'required|string|max:255|min:1',
      'date_start' => 'nullable|date',
      'date_finish'  => 'nullable|date',
      'country' => 'string',
      'city' => 'string',
      'venue' => 'string',
      'competition_series_id' => 'nullable|integer',

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


        //CREATE new Competition instance
        $competition = new Competition;

        $competition->name = $request->name;
        $competition->date_start = $request->date_start;
        $competition->date_finish = $request->date_finish;
        $competition->competition_series_id = $request->competition_series_id;
        $competition->country = $request->country;
        $competition->city = $request->city;
        $competition->venue = $request->venue;

        $competition->save();

        Link::store($competition, $request->link_name, $request->link_path);

        return redirect()->route('competition.index');
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
        $competition = Competition::find($id);
        return view('dashboard.competition.edit')->with('competition',$competition)->with('series',$series);
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
        $competition->competition_series_id = $request->competition_series_id;
        $competition->country = $request->country;
        $competition->city = $request->city;
        $competition->venue = $request->venue;

        $competition->save();

        Link::edit($competition, $request->link_name, $request->link_path);

        return redirect()->route('competition.index');
    }

}
