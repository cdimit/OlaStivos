<?php

namespace App\Http\Controllers\Dashboard;

use App\Athlete;
use App\Club;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AthleteCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET all the athletes
        $athletes = Athlete::all();

        return view('dashboard.athlete.index')->with('athletes',$athletes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clubs = Club::pluck('name','id'); //list of clubs for select field in create form
        
        return view('dashboard.athlete.create')->with('clubs',$clubs);
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
            'first_name' => 'required|string|max:255|min:1',
            'last_name' => 'required|string|max:255|min:1',
            'dob'  => 'date',
            'club_id' => 'integer',
            'gender' => 'string|required',
            'picture' => 'nullable|mimes:jpeg,bmp,png',
            
        ]);

        //CREATE new Athlete instance
        $athlete = new Athlete;

        $athlete->first_name = $request->first_name;
        $athlete->last_name = $request->last_name;
        $athlete->dob = $request->dob;
        $athlete->club_id = $request->club_id;
        $athlete->gender = $request->gender;

        if (!empty($request['picture'])) {
            $picture = $request['picture']->store('pictures/athletes'.$athlete->id);
        }else{
            $picture = 'default_athlete.png';
        }
        $athlete->picture = $picture;

        $athlete->save();
        
        return redirect()->route('athlete.index');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $athlete=Athlete::find($id);
        $clubs = Club::pluck('name','id'); //list of clubs for select field in form

        return view('dashboard.athlete.edit')->with('clubs',$clubs)->with('athlete',$athlete);
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
        $this->validate($request, [
            'first_name' => 'required|string|max:255|min:1',
            'last_name' => 'required|string|max:255|min:1',
            'dob'  => 'date',
            'club_id' => 'integer',
            'gender' => 'string|required',
            'picture' => 'nullable|mimes:jpeg,bmp,png',
            
        ]);


        $athlete = Athlete::find($id);

        $athlete->first_name = $request->first_name;
        $athlete->last_name = $request->last_name;
        $athlete->dob = $request->dob;
        $athlete->club_id = $request->club_id;
        $athlete->gender = $request->gender;

        if (!empty($request['picture'])) {
            $picture = $request['picture']->store('pictures/athletes'.$athlete->id);
            $athlete->picture = $picture;
        }

        $athlete->save();
        
        return redirect()->route('athlete.index');

    }


}