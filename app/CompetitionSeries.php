<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionSeries extends Model
{

    public function competition()
    {
        return $this->hasMany('App\Competition');
    }

    public function result()
    {
        return $this->hasMany('App\Result');
    }
}
