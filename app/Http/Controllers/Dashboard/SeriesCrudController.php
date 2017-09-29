<?php

namespace App\Http\Controllers\Dashboard;

use App\CompetitionSeries;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeriesCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //GET all the series
        $series = CompetitionSeries::all();

        return view('dashboard.series.index')->with('series',$series);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.series.create');
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
            'name' => 'required|string|max:255|min:1',
        ]);

        //CREATE new Series instance
        $series= new CompetitionSeries;

        $series->name = $request->name;

        $series->save();
        
        return redirect()->route('series.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $series = CompetitionSeries::find($id);
        return view('dashboard.series.edit')->with('series',$series);
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
            'name' => 'required|string|max:255|min:1',
        ]);

        //Get series instance and update it
        $series= CompetitionSeries::find($id);

        $series->name = $request->name;

        $series->save();
        
        return redirect()->route('series.index');
    }


}
