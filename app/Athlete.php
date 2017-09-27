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

    public function result()
    {
        return $this->hasMany('App\Result');
    }
}
