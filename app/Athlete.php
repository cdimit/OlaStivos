<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{


	  /**
	  * Return the relationship with User model.
	  */
  	public function club()
  	{
  		return $this->belongsTo('App\Club', 'club_id');
  	}

    public function links()
    {
      return $this->morphMany('App\Link', 'linkable');
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
