<?php

namespace App\Http\Controllers\Dashboard;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventCrudController extends Controller
{

    private $form_rules = [
      'name' => 'required|string|max:255|min:1',
      'type' => 'required|string|max:255|min:1',
      'season' => 'string|required',
      'gender' => 'string|required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET all the events

        $outdoorEvents = Event::where('season','outdoor')->get();
        $indoorEvents = Event::where('season','indoor')->get();
        $ccEvents = Event::where('season','cross country')->get();
        return view('dashboard.events.index')->with('outdoorEvents',$outdoorEvents)
                                         ->with('indoorEvents',$indoorEvents)
                                         ->with('ccEvents',$ccEvents);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.events.create');
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

        //CREATE new Athlete instance
        $event = new Event;

        $event->name = $request->name;
        $event->type = $request->type;
        $event->season = $request->season;
        $event->gender = $request->gender;

        $event->save();

 
        return redirect()->route('events.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event=Event::find($id);
        
        return view('dashboard.events.edit')->with('event',$event);
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

        $event = Event::find($id);
        $event->name = $request->name;
        $event->type = $request->type;
        $event->season = $request->season;
        $event->gender = $request->gender;

        $event->save();

        return redirect()->route('events.index');
    }


}
