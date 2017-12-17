<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Age;
use App\Traits\Linkable;
use App\Traits\Statusable;

class Athlete extends Model
{

    use Linkable;
    use Statusable;

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
      return $this->hasMany('App\Result')->published();
    }

		public function videos()
		{
			return $this->morphToMany('App\Video', 'videable');
		}

		public function images()
		{
			return $this->morphToMany('App\Image', 'imageable');
		}

    public function relayResults()
    {
      return $this->BelongsToMany('App\Result', 'relay_athletes', 'athlete_id', 'result_id')->published();
    }

    /****************************************************/
    //    Search Scope
    /****************************************************/
    public function scopeSearch($query,$search){

      // split on 1+ whitespace & ignore empty (eg. trailing space)
      $searchValues = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);

      return $query->where(function ($q) use ($searchValues) {
        foreach ($searchValues as $value) {
          $q->orWhere('first_name', 'like', "%{$value}%")
          ->orWhere('last_name','like', "%{$value}%");
        }
      })->orderBy('first_name','asc');

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

    public function getNameAttribute(): string
    {
      return $this->first_name . ' ' . $this->last_name;
    }

    public function isU16()
    {
      $age = Age::where('category', 'u16')->first();
      return $this->age >= $age->min && $this->age <= $age->max;
    }

    public function isU18()
    {
      $age = Age::where('category', 'u18')->first();
      return $this->age >= $age->min && $this->age <= $age->max;
    }

    public function isU20()
    {
      $age = Age::where('category', 'u20')->first();
      return $this->age >= $age->min && $this->age <= $age->max;
    }

    public function isU23()
    {
      $age = Age::where('category', 'u23')->first();
      return $this->age >= $age->min && $this->age <= $age->max;
    }

    public function isMale()
    {
      return $this->gender=='male';
    }

    public function isFemale()
    {
      return $this->gender=='female';
    }

    public function scopeMale($query)
    {
      return $query->where('gender', 'male')->get();
    }

    public function scopeFemale($query)
    {
      return $query->where('gender', 'female')->get();
    }


    /*
    ** Returns a collection of all results of this athlete over the years
    ** partitioned based on events ($key = $event_id , $value= collection of $Results )
    */
    public function getAllResultsByEvent()
    {

      //Get all results of athlete
      $results = $this->results->sortBy('date');

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
        $results = $competition->results
                          ->where('athlete_id',$this->id)
                          ->where('position','=',$position)
                          ->sortByDesc('date')
                          ->count();

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
    public function getPb($event, $date = null)
    {

      if(!$date){
        $date = Carbon::now();
      }

      //Get PB record ID
      $record = Record::where('acronym','PB')->first();
      $recordId = $record->id;

      //Get all PBs of athlete for this event
      $pbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->where('event_id',$event->id)->whereBetween('date',['1000-01-01' ,$date])->get();

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
    public function getSB($year, $event, $date = null)
    {

      if(!$date){
        $date = Carbon::now();
      }

      //Get SB record ID
      $record = Record::where('acronym','SB')->first();
      $recordId = $record->id;

      //Get SB of athlete for the year
      $sbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->where(DB::raw('YEAR(date)'), '=',$year)->where('event_id',$event->id)->whereBetween('date',['1000-01-01' ,$date])->get();

      //Find best PB based on event type
      $sb = $this->bestRecord($event,$sbs);
      return $sb;
    }


    /*
    // Returns a collection of all sbs of athlete over the years
    */
    public function getEverySb()
    {
      //Get SB record ID
      $record = Record::where('acronym','SB')->first();
      $recordId = $record->id;

      //Get SB of athlete for the year
      $sbs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id','=', $recordId);
      })->where('athlete_id',$this->id)->get();

      return $sbs;
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


    public function setPbIfExist($result, $event)
    {
      $pb = $this->getPb($event, $result->date);

      if(!$pb){
        $result->setPb($event);
        return true;
      }

      if($event->isTrack()){
        if($pb->mark>=$result->mark){
          $result->setPb($event);
          return true;
        }
      }else{
        if($pb->mark<=$result->mark){
          $result->setPb($event);
          return true;
        }
      }

      return false;
    }

    public function setSbIfExist($result, $event)
    {
      $date = Carbon::parse($result->date);
      $sb = $this->getSb($date->year ,$event, $result->date);

      if(!$sb){
        $result->setSb($event);
        return true;
      }

      if($event->isTrack()){
        if($sb->mark>=$result->mark){
          $result->setSb($event);
          return true;
        }
      }else{
        if($sb->mark<=$result->mark){
          $result->setSb($event);
          return true;
        }
      }

      return false;
    }

    public function setNRIfExist($result, $event)
    {
      $NR = $event->getNR($result->date);

      if(!$NR){
        $result->setNR($event);
        return true;
      }

      if($event->isTrack()){
        if($NR->mark>=$result->mark){
          $result->setNR($event);
          return true;
        }
      }else{
        if($NR->mark<=$result->mark){
          $result->setNR($event);
          return true;
        }
      }

      return false;
    }

    public function setNURIfExist($result, $event)
    {

      if(!Age::isU23($result->age)){
        return false;
      }

      $NUR = $event->getNUR($result->date);

      if(!$NUR){
        $result->setNUR($event);
        return true;
      }

      if($event->isTrack()){
        if($NUR->mark>=$result->mark){
          $result->setNUR($event);
          return true;
        }
      }else{
        if($NUR->mark<=$result->mark){
          $result->setNUR($event);
          return true;
        }
      }

      return false;
    }

    public function setNJRIfExist($result, $event)
    {

      if(!Age::isU20($result->age)){
        return false;
      }

      $NJR = $event->getNJR($result->date);

      if(!$NJR){
        $result->setNJR($event);
        return true;
      }

      if($event->isTrack()){
        if($NJR->mark>=$result->mark){
          $result->setNJR($event);
          return true;
        }
      }else{
        if($NJR->mark<=$result->mark){
          $result->setNJR($event);
          return true;
        }
      }

      return false;
    }

    public function setNYRIfExist($result, $event)
    {

      if(!Age::isU18($result->age)){
        return false;
      }

      $NYR = $event->getNYR($result->date);

      if(!$NYR){
        $result->setNYR($event);
        return true;
      }

      if($event->isTrack()){
        if($NYR->mark>=$result->mark){
          $result->setNYR($event);
          return true;
        }
      }else{
        if($NYR->mark<=$result->mark){
          $result->setNYR($event);
          return true;
        }
      }

      return false;
    }

    public function setEventRecords($event){
      foreach($event->results->where('is_recordable', 'true') as $result){
        $result->athlete->setRecordIfExist($result, true);
      }
    }


    public function setRecordIfExist($result)
    {

      $result->records()->detach();

      $this->setPbIfExist($result, $result->event);
      $this->setSbIfExist($result, $result->event);
      $this->setNYRIfexist($result, $result->event);
      $this->setNJRIfExist($result, $result->event);
      $this->setNURIfExist($result, $result->event);
      $this->setNRIfExist($result, $result->event);

      if($result->event->season=='indoor'){
        $out_event = Event::where('name', $result->event->name)
                            ->where('type', $result->event->type)
                            ->where('gender', $result->event->gender)
                            ->where('season', 'outdoor')->first();


        if($out_event){
          $this->setPbIfExist($result, $out_event);
          $this->setSbIfExist($result, $out_event);
          $this->setNYRIfexist($result, $out_event);
          $this->setNJRIfExist($result, $out_event);
          $this->setNURIfExist($result, $out_event);
          $this->setNRIfExist($result, $out_event);
        }
      }

    }



}
