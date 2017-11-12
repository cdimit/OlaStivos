<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Video;
use App\Athlete;
use App\Club;
use App\Competition;


class VideoCrudController extends Controller
{

    private $form_rules = [
      'name' => 'required|string|max:255|min:1',
      'path' => 'required|string'
      //'video'   => 'required|mimetypes:video/avi,video/mpeg,video/mp4',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $videos = Video::all();

      // dd($videos->first()->path);

      return view('dashboard.video.index')->with('videos',$videos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $athletes = Athlete::all();
      $clubs = Club::all();
      $competitions = Competition::all();

      return view('dashboard.video.create')->with('athletes',$athletes)
                                            ->with('clubs',$clubs)
                                            ->with('competitions',$competitions);
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


      $video = new Video;

      $video->name = $request->name;
      //$video->path = $request['video']->store('videos');
      $video->path = $request->path;

      $video->save();

      $video->athletes()->attach($request->athlete_id);
      $video->clubs()->attach($request->club_id);
      $video->competitions()->attach($request->competition_id);

      return redirect()->route('video.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $video=Video::find($id);

      $athletes = Athlete::all();
      $clubs = Club::all();
      $competitions = Competition::all();

      return view('dashboard.video.edit')->with('video',$video)
                                          ->with('athletes',$athletes->diff($video->athletes))
                                          ->with('clubs',$clubs->diff($video->clubs))
                                          ->with('competitions',$competitions->diff($video->competitions));
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
        'name' => 'required|string|max:255|min:1',
        'video' => 'nullable|mimetypes:video/avi,video/mpeg,video/mp4',
      ]);

      $video=Video::find($id);

      $video->name = $request->name;
      /*
      if (!empty($request['video'])) {
          $vid = $request['video']->store('videos');
          $video->path = $vid;
      }
      */
      $video->path = $request->path;
      $video->save();

      $video->athletes()->sync($request->athlete_id);
      $video->clubs()->sync($request->club_id);
      $video->competitions()->sync($request->competition_id);

      return redirect()->route('video.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
