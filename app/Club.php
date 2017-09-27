<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{

  public function athletes()
  {
    return $this->hasMany('App\Athlete');
  }

  public function links()
  {
    return $this->morphMany('App\Link', 'linkable');
  }
}
