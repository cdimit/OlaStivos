<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

  public function athletes()
  {
    return $this->morphedByMany('App\Athlete', 'imageable');
  }

  public function clubs()
  {
    return $this->morphedByMany('App\Club', 'imageable');
  }

  public function competitions()
  {
    return $this->morphedByMany('App\Competition', 'imageable');
  }
}
