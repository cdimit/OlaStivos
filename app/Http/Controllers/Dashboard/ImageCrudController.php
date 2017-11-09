<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Image;
use App\Athlete;
use App\Competition;
use App\Club;

class ImageCrudController extends Controller
{

    private $form_rules = [
      'name' => 'required|string|max:255|min:1',
      'picture' => 'required|mimes:jpeg,bmp,png',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //GET all the images
      $images = Image::all();

      return view('dashboard.image.index')->with('images',$images);
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

      return view('dashboard.image.create')->with('athletes',$athletes)
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


      $image = new Image;

      $image->name = $request->name;
      $image->path = $request['picture']->store('pictures/images');

      $image->save();

      $image->athletes()->attach($request->athlete_id);
      $image->clubs()->attach($request->club_id);
      $image->competitions()->attach($request->competition_id);

      return redirect()->route('image.index');
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
      $image=Image::find($id);

      $athletes = Athlete::all();
      $clubs = Club::all();
      $competitions = Competition::all();

      return view('dashboard.image.edit')->with('image',$image)
                                          ->with('athletes',$athletes->diff($image->athletes))
                                          ->with('clubs',$clubs->diff($image->clubs))
                                          ->with('competitions',$competitions->diff($image->competitions));
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
        'picture' => 'nullable|mimes:jpeg,bmp,png',
      ]);

      $image=Image::find($id);

      $image->name = $request->name;

      if (!empty($request['picture'])) {
          $picture = $request['picture']->store('pictures/images');
          $image->path = $picture;
      }
      $image->save();

      $image->athletes()->sync($request->athlete_id);
      $image->clubs()->sync($request->club_id);
      $image->competitions()->sync($request->competition_id);

      return redirect()->route('image.index');
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
