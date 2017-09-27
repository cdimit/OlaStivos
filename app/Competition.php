<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    
    public function series()
    {
        return $this->belongsTo('App\CompetitionSeries');
    }

    public function result()
    {
        return $this->hasMany('App\Result');
    }

}
