<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{

    public function series()
    {
        return $this->belongsTo('App\CompetitionSeries', 'competition_series_id');
    }

    public function results()
    {
        return $this->hasMany('App\Result');
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
