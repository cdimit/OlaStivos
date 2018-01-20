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
        'order' => 'integer'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET all the events

        $outdoorEvents = Event::where('season','outdoor')->get()->sortBy('order');
        $indoorEvents = Event::where('season','indoor')->get()->sortBy('order');
        $ccEvents = Event::where('season','cross country')->get()->sortBy('order');
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

        $event->order = $request->order;

        $event->save();

        $this->fixOrder("store",$event);
 
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

        $oldevent = Event::find($id);
        
        $newevent = Event::find($id);
        $newevent->name = $request->name;
        $newevent->type = $request->type;
        $newevent->season = $request->season;
        $newevent->gender = $request->gender;

        $newevent->order = $request->order;
        
        $newevent->save();
        
        $this->fixOrder("update",$newevent,$oldevent);
        
        return redirect()->route('events.index');
    }

    private function fixOrder($action,$newevent,$oldevent = null)
    {
        if($action =="store"){
            
            $change_events = Event::where('id','!=',$newevent->id)
                                    ->where('order','>=',$newevent->order)
                                    ->get();
            foreach ($change_events as $change_event) {
                $event->order = $event->order + 1;
                $event->save();    
            }

        }elseif($action="update"){
            //if order hasnt changed------> return
            if ($newevent->order === $oldevent->order){
                return;

            }elseif($newevent->order > $oldevent->order){//if order is changed to bigger number
                $events_before = Event::where('id','!=',$newevent->id)
                                        ->where('order','<=',$newevent->order)
                                        ->where('order','>=',$oldevent->order)
                                        ->get();
                foreach ($events_before as $change_event) {
                    $change_event->order = $change_event->order - 1;
                    $change_event->save();    
                }   
                     
            }elseif($newevent->order < $oldevent->order){//if order is changed to smaller number
                $events_before = Event::where('id','!=',$newevent->id)
                                        ->where('order','>=',$newevent->order)
                                        ->where('order','<=',$oldevent->order)
                                        ->get();
                foreach ($events_before as $change_event) {
                    $change_event->order = $change_event->order + 1;
                    $change_event->save();    
                }  
            }

        }
        return;
    }


}
