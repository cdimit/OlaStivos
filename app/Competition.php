<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{

    public function series()
    {
        return $this->belongsTo('App\CompetitionSeries');
    }

    public function results()
    {
        return $this->hasMany('App\Result');
    }

    public function videos()
    {
      return $this->morphToMany(Video::class, 'videable');
    }

    public function images()
		{
			return $this->morphToMany(Image::class, 'imageable');
		}
}
