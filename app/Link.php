<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{

  /**
   * Don't auto-apply mass assignment protection.
   *
   * @var array
   */
  protected $guarded = [];

  public function linkable()
  {
    return $this->morphTo();
  }
}
