<?php

namespace App\Http\Controllers;

use App\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    //
    public function show(Club $club)
    {
    	return view('club.show')->with('club',$club);
    }

}
