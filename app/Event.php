<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Record;
use App\Result;
use Carbon\Carbon;

class Event extends Model
{
    public function results()
    {
        return $this->hasMany('App\Result');
    }

    public function records()
    {
        return $this->hasMany('App\PivotRecord');
    }

    public function record_results($recordId)
    {
      return $this->BelongsToMany('App\Result', 'result_record', 'event_id', 'result_id')->where('record_id', '$recordId');
    }

    public function isTrack()
    {
      return $this->type=='track';
    }

    public function isField()
    {
      return $this->type=='field';
    }

    public function getIndoor()
    {
      return self::where('name', $this->name)
                    ->where('type', $this->type)
                    ->where('season', 'indoor')
                    ->where('gender', $this->gender)
                    ->first();
    }

    public function getNR($date = null)
    {

      if(!$date){
        $date = Carbon::now();
      }

      //Get PB record ID
      $record = Record::where('acronym','NR')->first();
      $recordId = $record->id;

      //Get all PBs of athlete for this event
      $nrs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id', $recordId)->where('event_id', $this->id);
      })->whereBetween('date',['1000-01-01' ,$date])->get();

      $nr = $nrs->sortByDesc('date')->first();

      return $nr;

    }

    public function getNUR($date = null)
    {

      if(!$date){
        $date = Carbon::now();
      }

      //Get PB record ID
      $record = Record::where('acronym','NUR')->first();
      $recordId = $record->id;

      //Get all PBs of athlete for this event
      $nrs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id', $recordId)->where('event_id', $this->id);
      })->whereBetween('date',['1000-01-01' ,$date])->get();

      $nr = $nrs->sortByDesc('date')->first();

      return $nr;
    }

    public function getNJR($date = null)
    {

      if(!$date){
        $date = Carbon::now();
      }

      //Get PB record ID
      $record = Record::where('acronym','NJR')->first();
      $recordId = $record->id;

      //Get all PBs of athlete for this event
      $nrs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id', $recordId)->where('event_id', $this->id);
      })->whereBetween('date',['1000-01-01' ,$date])->get();

      $nr = $nrs->sortByDesc('date')->first();

      return $nr;
    }

    public function getNYR($date = null)
    {

      if(!$date){
        $date = Carbon::now();
      }

      //Get PB record ID
      $record = Record::where('acronym','NYR')->first();
      $recordId = $record->id;

      //Get all PBs of athlete for this event
      $nrs = Result::whereHas('records',function ($query) use ($recordId) {
        $query->where('record_id', $recordId)->where('event_id', $this->id);
      })->whereBetween('date',['1000-01-01' ,$date])->get();

      $nr = $nrs->sortByDesc('date')->first();

      return $nr;
    }

    public function scopeOutdoor($query)
    {
      return $query->where('season', 'outdoor')->get();
    }

    public function scopeIndoor($query)
    {
      return $query->where('season', 'indoor')->get();
    }

    public function scopeMale($query)
    {
      return $query->where('gender', 'male')->get();
    }

    public function scopeFemale($query)
    {
      return $query->where('gender', 'female')->get();
    }


    public function getAllRecords($acronym)
    {
      $results = $this->records->where('record_id', Record::where('acronym', $acronym)->first()->id);

      $records = collect([]);
      foreach ($results as $result) {
        $records->push(Result::find($result->result_id));
      }

      return $records->sortBy('date');
    }

    public function getSezonAttribute(): string
    {
      if($this->season == 'indoor'){
        return 'Κλειστός Στίβος';
      }elseif($this->season == 'outdoor'){
        return 'Ανοικτός Στίβος';
      }else{
        return 'Ανώμαλος Δρόμος';
      }
    }

    public function refreshRecords($date = null){

      if($date){
        $results =  $this->results->where('is_recordable', true)->where('date','>=', $date)->sortBy('date');
        if($this->type!="indoor" && $this->getIndoor()!=null){
          $resultsIndoor =  $this->getIndoor()->results->where('is_recordable', true)->where('date','>=', $date);
          $results = $results->merge($resultsIndoor)->sortBy('date');

        }
      }else{
        $results = $this->results->where('is_recordable', true)->sortBy('date');
        if($this->type!="indoor"){
          $resultsIndoor =  $this->getIndoor()->results->where('is_recordable', true);
          $results = $results->merge($resultsIndoor)->sortBy('date');
        }
      }

      foreach($results as $result){
        $result->athlete->setRecordIfExist($result, true);
      }


    }
}
