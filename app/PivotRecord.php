<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PivotRecord extends Model
{
  /**
   * Don't auto-apply mass assignment protection.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'result_record';

  
}
