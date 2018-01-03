<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Record;
use Carbon\Carbon;
use App\Traits\Statusable;

class Result extends Model
{
    use Statusable;

    public function competition()
    {
        return $this->belongsTo('App\Competition');
    }

    public function athlete()
    {
        return $this->belongsTo('App\Athlete');
    }

    public function relayAthletes()
    {
      return $this->BelongsToMany('App\Athlete', 'relay_athletes', 'result_id', 'athlete_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function records()
    {
		  return $this->BelongsToMany('App\Record', 'result_record', 'result_id', 'record_id')->withTimestamps();
    }



    public function getMarkstrAttribute(): string
    {
      if($this->event->isTrack()){
        if(starts_with($this->mark, '00:00:0')){
          return str_replace_first('00:00:0', '', $this->mark);
        }elseif(starts_with($this->mark, '00:00:')){
          return str_replace_first('00:00:', '', $this->mark);
        }elseif(starts_with($this->mark, '00:0')){
          return str_replace_first('00:0', '', $this->mark);
        }elseif(starts_with($this->mark, '00:0')){
          return str_replace_first('00:', '', $this->mark);
        }elseif(starts_with($this->mark, '00:')){
          return str_replace_first('00:', '', $this->mark);
        }elseif(starts_with($this->mark, '0')){
          $tmp =  str_replace_first('0', '', $this->mark);
          return substr($tmp, 0, 7);
        }
      }
      return $this->mark;
    }

    public function setPb($event)
    {
      return $this->records()->attach(Record::where('acronym', 'PB')->first()->id, ['event_id' => $event->id]);

    }

    public function setSb($event)
    {
      return $this->records()->attach(Record::where('acronym', 'SB')->first()->id, ['event_id' => $event->id]);
    }

    public function setNR($event)
    {
      return $this->records()->attach(Record::where('acronym', 'NR')->first()->id, ['event_id' => $event->id]);

    }

    public function setNUR($event)
    {
      return $this->records()->attach(Record::where('acronym', 'NUR')->first()->id, ['event_id' => $event->id]);
    }

    public function setNJR($event)
    {
      return $this->records()->attach(Record::where('acronym', 'NJR')->first()->id, ['event_id' => $event->id]);
    }

    public function setNYR($event)
    {
      return $this->records()->attach(Record::where('acronym', 'NYR')->first()->id, ['event_id' => $event->id]);
    }


    public function scopeYears($query)
    {
      $dates = $query->pluck('date')->sort()->unique();

      $years = collect([]);
      foreach($dates as $date){
        $years->push(Carbon::parse($date)->year);
      }

      return $years->unique();
    }

    public function scopeFromYear($query, $year)
    {
      return $query->whereYear('date', $year)->get();
    }

}
