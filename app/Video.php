<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  protected $guarded = [];

  public function athletes()
  {
    return $this->morphedByMany('App\Athlete', 'videable');

    // return $this->BelongsToMany('App\Record', 'result_record', 'result_id', 'record_id');

  }
}
