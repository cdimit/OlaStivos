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




    /*
    ** Returns a collection of all results of this competition
    ** partitioned based on events ($key = $event_id , $value= collection of $Results )
    */
    public function getAllResults()
    {

      //Get all results of competition
      $results = $this->results->sortBy('date')->sortBy('position');

      //Find events in which athlete has results
      $events = $this->uniqueEvents($results);

      //create a collection with keys the event_id and values the Results
      $collection=collect([]);
      foreach($events as $event){
        $eventResults = $results->where('event_id',$event);
        $collection = $collection->put($event, $eventResults);
      }

      return $collection;
    }

    /*
    // Returns an array with all the unique events of the results
    */
    public function uniqueEvents($results)
    {
      $events = $results->mapWithKeys(function ($item) {
        return [$item['event_id']=>$item];
      })->keys();

      return $events->toArray();
    }





}
