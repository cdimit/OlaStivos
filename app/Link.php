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

  public static function store($var, $name, $path)
  {
    for($i=0; $i<sizeof($name); $i++){
      $var->links()->create([
            'name' => $name[$i],
            'path' => $path[$i]
          ]);

    }
  }

  public static function edit($var, $name, $path)
  {
    $var->removeLinks();
    for($i=0; $i<sizeof($name); $i++){
      $var->links()->create([
          'name' => $name[$i],
          'path' => $path[$i]
      ]);
    }
  }

}
