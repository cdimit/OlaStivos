<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  protected $guarded = [];

  public function athletes()
  {
    return $this->morphedByMany('App\Athlete', 'videable');
  }

  public function clubs()
  {
    return $this->morphedByMany('App\Club', 'videable');
  }

  public function competitions()
  {
    return $this->morphedByMany('App\Competition', 'videable');
  }

}
