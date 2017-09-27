<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
  /**
  * Return the meeting points than client create.
  */
  public function athletes()
  {
    return $this->hasMany('App\Athlete');
  }
}
