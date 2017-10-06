<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Age;

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

    public function getAgeAttribute(): string
    {
      $date = new \DateTime('now');
      $difference = $date->diff(new \DateTime($this->dob));
      return $difference->format('%y');
    }

    public function isU16()
    {
      $age = Age::where('name', 'u16')->first();
      return $this->age >= $age->min && $this->age <= $age->max;
    }

    public function isU18()
    {
      $age = Age::where('name', 'u18')->first();
      return $this->age >= $age->min && $this->age <= $age->max;
    }

    public function isU20()
    {
      $age = Age::where('name', 'u20')->first();
      return $this->age >= $age->min && $this->age <= $age->max;
    }

    public function isU23()
    {
      $age = Age::where('name', 'u23')->first();
      return $this->age >= $age->min && $this->age <= $age->max;
    }

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
      if ($event->isField()){
        $pb = $records->where('mark','=',$records->max('mark'))->first();
      }else{
        $pb = $records->where('mark','=',$records->min('mark'))->first();
      }

      return $pb;
    }

    public function setPbIfExist($result)
    {
      $pb = $this->getPb($result->event);

      if(!$pb){
        $result->setPb();
        return true;
      }

      if($result->event->isTrack()){
        if($pb->mark>=$result->mark){
          $result->setPb();
          return true;
        }
      }else{
        if($pb->mark<=$result->mark){
          $result->setPb();
          return true;
        }
      }

      return false;
    }

    public function setSbIfExist($result)
    {
      $date = Carbon::parse($result->date);
      $sb = $this->getSb($date->year ,$result->event);

      if(!$sb){
        $result->setSb();
        return true;
      }

      if($result->event->isTrack()){
        if($sb->mark>=$result->mark){
          $result->setSb();
          return true;
        }
      }else{
        if($sb->mark<=$result->mark){
          $result->setSb();
          return true;
        }
      }

      return false;
    }

    public function setNRIfExist($result)
    {
      $NR = $result->event->getNR();

      if(!$NR){
        $result->setNR();
        return true;
      }

      if($result->event->isTrack()){
        if($NR->mark>=$result->mark){
          $result->setNR();
          return true;
        }
      }else{
        if($NR->mark<=$result->mark){
          $result->setNR();
          return true;
        }
      }

      return false;
    }

    public function setNURIfExist($result)
    {

      if(!Age::isU23($result->age)){
        return false;
      }

      $NUR = $result->event->getNUR();

      if(!$NUR){
        $result->setNUR();
        return true;
      }

      if($result->event->isTrack()){
        if($NUR->mark>=$result->mark){
          $result->setNUR();
          return true;
        }
      }else{
        if($NUR->mark<=$result->mark){
          $result->setNUR();
          return true;
        }
      }

      return false;
    }

    public function setNJRIfExist($result)
    {

      if(!Age::isU20($result->age)){
        return false;
      }

      $NJR = $result->event->getNJR();

      if(!$NJR){
        $result->setNJR();
        return true;
      }

      if($result->event->isTrack()){
        if($NJR->mark>=$result->mark){
          $result->setNJR();
          return true;
        }
      }else{
        if($NJR->mark<=$result->mark){
          $result->setNJR();
          return true;
        }
      }

      return false;
    }

    public function setNYRIfExist($result)
    {

      if(!Age::isU18($result->age)){
        return false;
      }

      $NYR = $result->event->getNYR();

      if(!$NYR){
        $result->setNYR();
        return true;
      }

      if($result->event->isTrack()){
        if($NYR->mark>=$result->mark){
          $result->setNYR();
          return true;
        }
      }else{
        if($NYR->mark<=$result->mark){
          $result->setNYR();
          return true;
        }
      }

      return false;
    }

    public function setRecordIfExist($result)
    {

      $this->setPbIfExist($result);
      $this->setSbIfExist($result);
      $this->setNYRIfexist($result);
      $this->setNJRIfExist($result);
      $this->setNURIfExist($result);
      $this->setNRIfExist($result);

    }
}
