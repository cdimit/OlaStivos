<?php

namespace App\Http\Controllers;

use App\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function show(Competition $competition)
    {
    	$results = $competition->getAllResultsByEvent();
    	return view('competition.show')->with('competition',$competition)
    								->with('results',$results);
    }




}
