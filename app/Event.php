<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Record;
use App\Result;

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

    public function isTrack()
    {
      return $this->type=='track';
    }

    public function isField()
    {
      return $this->type=='field';
    }

    public function getNR()
    {
      $result = $this->records->where('record_id', Record::where('acronym', 'NR')->first()->id)->sortByDesc('date')->first();
      if($result){
        return Result::find($result->id);
      }

      return null;
    }

    public function getNUR()
    {
      $result = $this->records->where('record_id', Record::where('acronym', 'NUR')->first()->id)->sortByDesc('date')->first();
      if($result){
        return Result::find($result->id);
      }

      return null;
    }

    public function getNJR()
    {
      $result = $this->records->where('record_id', Record::where('acronym', 'NJR')->first()->id)->sortByDesc('date')->first();
      if($result){
        return Result::find($result->id);
      }

      return null;
    }

    public function getNYR()
    {
      $result = $this->records->where('record_id', Record::where('acronym', 'NYR')->first()->id)->sortByDesc('date')->first();
      if($result){
        return Result::find($result->id);
      }

      return null;
    }

    public function scopeOutdoor($query)
    {
      return $query->where('season', 'outdoor')->get();
    }

    public function scopeIndoor($query)
    {
      return $query->where('season', 'indoor')->get();
    }


    public function getAllRecords($acronym)
    {
      $results = $this->records->where('record_id', Record::where('acronym', $acronym)->first()->id);

      $records = collect([]);
      foreach ($results as $result) {
        $records->push(Result::find($result->id));
      }

      return $records->sortBy('date');
    }
}
