<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function result()
    {
        return $this->hasMany('App\Result');
    }

    public function record()
    {
        return $this->hasMany('App\Record');
    }
}
