<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{

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

}
