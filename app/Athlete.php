<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Athlete extends Model
{


    /**********************************
    //  Relationships
    ***********************************/
  	
    public function club()
  	{
  		return $this->belongsTo('App\Club', 'club_id');
  	}

    public function links()
    {
      return $this->morphMany('App\Link', 'linkable');
    }

    public function results()
    {
      return $this->hasMany('App\Result');
    }

		public function videos()
		{
			return $this->morphToMany('App\Video', 'videable');
		}

		public function images()
		{
			return $this->morphToMany('App\Image', 'imageable');
		}


    /**********************************
    //  Functions that return results
    ***********************************/

    /*
    ** Returns a collection of all results of this athlete over the years
    ** partitioned based on events ($key = $event_id , $value= collection of $Results )
    */
    public function getAllResults()
    {

      //Get all results of athlete
      $results = Result::where('athlete_id',$this->id)->orderBy('date','ASC')->get();
      
      //Find events in which athlete has results
      $events = $this->uniqueEvents($results);
      
      //create a collection with keys the event_id and values the Result records
      $collection=collect([]);
      foreach($events as $event){
        $eventResults = $results->where('event_id',$event);
        $collection = $collection->put($event, $eventResults);
      }

      return $collection;
    }



    /*
    ** Returns a collection of all results of this athlete
    ** in competition of the series= $series
    ** that finished in position= $position
    */
    public function countPlaces($series,$position)
    {
      $competitions = Competition::where('competition_series_id',$series->id)->get();
      $count = 0;
      foreach($competitions as $competition){
        $results = Result::where('competition_id',$competition->id)
                          ->where('athlete_id',$this->id)
                          ->where('position','=',$position)
                          ->orderBy('date','DESC')
                          ->get()->count();
        
        $count = $count+$results;
      }
    
      return $count;
    }



    
    /**********************************
    //  Functions that return records
    //  -----     PB      ----- 
    ***********************************/

    /*
    ** Returns a collection of all PBs of this athlete over the years
    ** partitioned based on events ($key = $event_id , $value= collection of $PBs )
    */
    public function getAllPbs()
    {
      //Get PB record ID
      $record = Record::where('acronym','PB')->first();
      $recordId = $record->id;

      //Get all PBs of athlete
      $pbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->get();
      
      //Find events in which athlete has pbs
      $events = $this->uniqueEvents($pbs);
      
      //create a collection with keys the event_id and values the PBs
      $collection=collect([]);
      foreach($events as $event){
        $eventPbs = $pbs->where('event_id',$event);
        $collection = $collection->put($event, $eventPbs);
      }

      return $collection;
    }

    /*
    ** Returns a collection of all PBs of this athlete RIGHT NOW
    ** partitioned based on events ($key = $event_id , $value= PB )
    */
    public function getPbs()
    {
      //Get PB record ID
      $record = Record::where('acronym','PB')->first();
      $recordId = $record->id;
      
      //Get all PBs of athlete
      $pbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->get();
      
      //Find events in which athlete has pbs
      $events = $this->uniqueEvents($pbs);
      
      //create a collection with keys the event_id and values the PBs
      $collection=collect([]);
      foreach($events as $event){
        //All PBs made for the event by the athlete
        $eventPbs = $pbs->where('event_id',$event);
        //Find best PB 
        $eventPb = $this->bestRecord(Event::find($event),$eventPbs);

        //Add PB to collection with key the event id
        $collection = $collection->put($event, $eventPb);
      }

      return $collection;
    }

    /*
    ** Returns a collection of all PBs of this athlete for a specific EVENT over 
    ** the years
    */
    public function getPbsEvent($event)
    {
      //Get PB record ID
      $record = Record::where('acronym','PB')->first();
      $recordId = $record->id;

      //Get all pbs of athlete on the $event
      $pbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->where('event_id',$event->id)->get();

      return $pbs;
    }

    /*
    // Returns THE PB of this athlete for a specific EVENT
    */
    public function getPb($event)
    {
      //Get PB record ID
      $record = Record::where('acronym','PB')->first();
      $recordId = $record->id;
      
      //Get all PBs of athlete for this event
      $pbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->where('event_id',$event->id)->get();

      //Find best PB based on event type
      $pb = $this->bestRecord($event,$pbs);
      return $pb;
    }





    /**********************************
    //  Functions that return records
    //  -----     SB      ----- 
    ***********************************/
    
    /*
    // Returns a collection of all SBs of this athlete for a specific YEAR
    */
    public function getAllSBs($year)
    {
      //Get SB record ID
      $record = Record::where('acronym','SB')->first();
      $recordId = $record->id;
      
      //Get SB of athlete for the year
      $sbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->where(DB::raw('YEAR(date)'), '=',$year)->get();
      
      return $sbs;
    }


    /*
    // Returns a collection of THE BEST SBs of this athlete for a specific YEAR
    */
    public function getSBs($year)
    {
      //Get SB record ID
      $record = Record::where('acronym','SB')->first();
      $recordId = $record->id;

      //Get SB of athlete for the year
      $sbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->where(DB::raw('YEAR(date)'), '=',$year)->get();

      //Find events in which athlete has pbs
      $events = $this->uniqueEvents($sbs);
      
      //create a collection with keys the event_id and values the SBs
      $collection=collect([]);
      foreach($events as $event){
        //All SBs made for the event by the athlete
        $eventSbs = $sbs->where('event_id',$event);
        //Find best SB 
        $eventSb = $this->bestRecord(Event::find($event),$eventSbs);

        //Add PB to collection with key the event id
        $collection = $collection->put($event, $eventSb);
      }

      return $collection;
    }

    /*
    // Returns a collection of the SBs of this athlete for a specific YEAR
    ///and for a specific EVENT
    */
    public function getSBsEvent($year, $event)
    {
      //Get SB record ID
      $record = Record::where('acronym','SB')->first();
      $recordId = $record->id;
      
      //Get SB of athlete for the year
      $sbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->where(DB::raw('YEAR(date)'), '=',$year)->where('event_id',$event->id)->get();
      
      return $sbs;
    }

    /*
    // Returns the best SB of this athlete for a specific YEAR
    ///and for a specific EVENT
    */
    public function getSB($year, $event)
    {
      //Get SB record ID
      $record = Record::where('acronym','SB')->first();
      $recordId = $record->id;
      
      //Get SB of athlete for the year
      $sbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->where(DB::raw('YEAR(date)'), '=',$year)->where('event_id',$event->id)->get();

      //Find best PB based on event type
      $sb = $this->bestRecord($event,$sbs);
      return $sb;
    }
  




    /**********************************
    //  Functions that return records
    //  -----     NR      ----- 
    ***********************************/


    /*
    ** Returns a collection of all NRs of this athlete RIGHT NOW
    ** partitioned based on events ($key = $event_id , $value= NR )
    ** Parameter $acronym determines which category (Senior, U23....)
    */
    public function getNRs($acronym)
    {

      //Get NR record ID
      $record = Record::where('acronym','like',$acronym)->first();
      $recordId = $record->id;
      
      //Get all NRs of athlete
      $NRs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->get();

      //Find events in which athlete has NRs
      $events = $this->uniqueEvents($NRs);
      
      //create a collection with keys the event_id and values the NRs
      $collection=collect([]);
      foreach($events as $event){
        //All NRs made for the event by the athlete
        $eventNRs = $NRs->where('event_id',$event);
        //Find best NR 
        $eventNR = $this->bestRecord(Event::find($event),$eventNRs);

        //Add NR to collection with key the event id
        $collection = $collection->put($event, $eventNR);
      }

      return $collection;
    }



    /**********************************
    //  HELPER FUNCTIONS
    //   
    ***********************************/
    /*
    // Returns an array with all the unique events of the results
    */
    public function uniqueEvents($results)
    {
      $events = $results->mapWithKeys(function ($item) {
        return [$item['event_id']=>$item];
      })->keys();

      return $events->toArray();
    }

    /*
    // Returns the best record among records based on type of event TRACK or FIELD
    */
    public function bestRecord($event,$records)
    {
      if ($event->type == 'field'){
        $pb = $records->where('mark','=',$records->max('mark'))->first();
      }else{
        $pb = $records->where('mark','=',$records->min('mark'))->first();
      }

      return $pb;
    }
}
