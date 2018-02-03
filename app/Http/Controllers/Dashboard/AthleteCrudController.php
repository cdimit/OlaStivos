<?php

namespace App\Http\Controllers\Dashboard;

use App\Athlete;
use App\Club;
use App\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AthleteCrudController extends Controller
{

    private $form_rules = [
      'first_name' => 'required|string|max:255|min:1',
      'last_name' => 'required|string|max:255|min:1',
      'dob'  => 'date',
      'club_id' => 'integer',
      'gender' => 'string|required',
      'picture' => 'nullable|mimes:jpeg,bmp,png',

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
        $this->validate($request, $this->form_rules);

        $athleteDB = Athlete::where([
                              'first_name' => $request->first_name,
                              'last_name' => $request->last_name,
                              'dob' => $request->dob,
                              'gender' => $request->gender
                            ])->get();

        if(!$athleteDB->isEmpty()){
          return redirect()->route('athlete.index')->withStatus("Athlete is already exist!");
        }

        //CREATE new Athlete instance
        $athlete = new Athlete;

        if($request->udob){
          $athlete->year = $request->year;
          $athlete->dob = null;
        }else{
          $athlete->dob = $request->dob;
          $athlete->year = (new \DateTime($request->dob))->format('Y');
        }

        $athlete->first_name = $request->first_name;
        $athlete->last_name = $request->last_name;
        $athlete->club_id = $request->club_id;
        $athlete->gender = $request->gender;

        if (!empty($request['picture'])) {
            $picture = $request['picture']->store('pictures/athletes');
        }else{
            $picture = '/img/athlete.png';
        }
        $athlete->picture = $picture;

        $athlete->save();

        Link::store($athlete, $request->link_name, $request->link_path);

        return redirect()->route('athlete.index')->withStatus("Athlete stored!");;

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

        $this->validate($request, $this->form_rules);


        $athlete = Athlete::find($id);

        $athlete->first_name = $request->first_name;
        $athlete->last_name = $request->last_name;
        $athlete->dob = $request->dob;
        $athlete->club_id = $request->club_id;
        $athlete->gender = $request->gender;

        if (!empty($request['picture'])) {
            $picture = $request['picture']->store('pictures/athletes');
            $athlete->picture = $picture;
        }

        $athlete->save();

        Link::edit($athlete, $request->link_name, $request->link_path);

        return redirect()->route('athlete.index')->withStatus("Athlete updated!");;

    }


}
