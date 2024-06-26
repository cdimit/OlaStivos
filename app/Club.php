<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Linkable;

class Club extends Model
{

  use Linkable;

  public function athletes()
  {
    return $this->hasMany('App\Athlete');
  }

  public function links()
  {
    return $this->morphMany('App\Link', 'linkable');
  }

  public function videos()
  {
    return $this->morphToMany('App\Video', 'videable');
  }

  public function images()
  {
    return $this->morphToMany('App\Image', 'imageable');
  }
}
