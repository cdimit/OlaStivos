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

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function records()
    {
		return $this->BelongsToMany('App\Record', 'result_record', 'result_id', 'record_id')->withTimestamps();
    }

    public function setPb()
    {
      return $this->records()->attach(Record::where('acronym', 'PB')->first()->id, ['event_id' => $this->event->id]);

    }

    public function setSb()
    {
      return $this->records()->attach(Record::where('acronym', 'SB')->first()->id, ['event_id' => $this->event->id]);
    }

    public function setNR()
    {
      return $this->records()->attach(Record::where('acronym', 'NR')->first()->id, ['event_id' => $this->event->id]);

    }

    public function setNUR()
    {
      return $this->records()->attach(Record::where('acronym', 'NUR')->first()->id, ['event_id' => $this->event->id]);
    }

    public function setNJR()
    {
      return $this->records()->attach(Record::where('acronym', 'NJR')->first()->id, ['event_id' => $this->event->id]);
    }

    public function setNYR()
    {
      return $this->records()->attach(Record::where('acronym', 'NYR')->first()->id, ['event_id' => $this->event->id]);
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
