<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

  public function athletes()
  {
    return $this->morphedByMany('App\Athlete', 'imageable');
  }
}
