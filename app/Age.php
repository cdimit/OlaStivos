<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Age extends Model
{

  public static function isU16($age)
  {
    $raw = $this->where('name', 'u16')->first();
    return $age >= $raw->min && $age <= $raw->max;
  }

  public static function isU18($age)
  {
    $raw = Age::where('name', 'u18')->first();
    return ($age >= $raw->min) && ($age <= $raw->max);
  }

  public static function isU20($age)
  {
    $raw = Age::where('name', 'u20')->first();
    return $age >= $raw->min && $age <= $raw->max;
  }

  public static function isU23($age)
  {
    $raw = Age::where('name', 'u23')->first();
    return $age >= $raw->min && $age <= $raw->max;
  }
}