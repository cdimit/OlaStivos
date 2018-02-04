<?php

namespace App\Http\Controllers\Dashboard;

use App\Athlete;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommandController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.commands.index');
    }

    /**
     * Fix year collumn in athletes that only have DOB
     *
     * @return \Illuminate\Http\Response
     */
    public function fixYearInAthletes($athletes = null)
    {
    	// Touto en se periptwsi pou theloume na perasoume sigkekrimenous athlites sto mellon
    	if($athletes === null){
   			$athletes = Athlete::where('dob','!=',null)->get();
    	}

   		foreach ($athletes as $athlete) {
        	$athlete->year = (new \DateTime($athlete->dob))->format('Y');
        	$athlete->save();
   		}
        return redirect()->route('commands.index')->withStatus("Athletes Year Collumn updated!");
    }

}
