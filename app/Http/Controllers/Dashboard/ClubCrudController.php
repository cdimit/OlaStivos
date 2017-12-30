<?php

namespace App\Http\Controllers\Dashboard;

use App\Club;
use App\Link;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ClubCrudController extends Controller
{

  private $form_rules = [
    'name' => 'required|string|max:255|min:1',
    'acronym' => 'required|string|max:10',
    'city'  => 'required|string|max:255|min:1',
    'since' => 'nullable|integer|min:1800|max:2017',
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
        //GET all the clubs
        $clubs = Club::all();

        return view('dashboard.club.index')->with('clubs',$clubs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.club.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, $this->form_rules);


        $club = new Club;

        $club->name = $request->name;
        $club->acronym = $request->acronym;
        $club->city = $request->city;
        $club->since = $request->since;

        if (!empty($request->picture)) {
            $picture = '/storage/'.$request['picture']->store('pictures/clubs');
        }else{
            $picture = '/img/club.png';
        }
        $club->picture = $picture;

        $club->save();

        Link::store($club, $request->link_name, $request->link_path);

        return redirect()->route('club.index');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $club=Club::find($id);
        return view('dashboard.club.edit')->with('club',$club);
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

        request()->validate($this->form_rules);

        $club=Club::find($id);

        $club->name = $request->name;
        $club->acronym = $request->acronym;
        $club->city = $request->city;
        $club->since = $request->since;

        if (!empty($request['picture'])) {
            if($club->picture != '/img/club.png' ){
                Storage::delete(str_replace_first('/storage/', '', $club->picture));
            }
            $picture = '/storage/'.$request['picture']->store('pictures/clubs');
            $club->picture = $picture;
        }


        $club->save();

        Link::edit($club, $request->link_name, $request->link_path);

        return redirect()->route('club.index');

    }

}
