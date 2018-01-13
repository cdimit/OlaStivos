<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Traits\Linkable;
use App\Traits\Statusable;

class Competition extends Model
{

    use Linkable;
    use Statusable;
    
    public function series()
    {
        return $this->belongsTo('App\CompetitionSeries', 'competition_series_id');
    }

    public function results()
    {
        return $this->hasMany('App\Result')->published();
    }

    public function videos()
		{
			return $this->morphToMany('App\Video', 'videable');
		}

	   public function images()
	   {
		  return $this->morphToMany('App\Image', 'imageable');
	   }

     public function links()
     {
       return $this->morphMany('App\Link', 'linkable');
     }


    /*
    ** Returns a collection of all results of this competition
    ** partitioned based on events ($key = $event_id , $value= collection of $Results )
    */
    public function getAllResultsByEvent()
    {

      //Get all results of competition
      $results = $this->results->sortBy('position');

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


    /****************************************************/
    //    Search Scope
    /****************************************************/
    public function scopeSearch($query,$search){
      // split on 1+ whitespace & ignore empty (eg. trailing space)
      $searchValues = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);

      return $query->where(function ($q) use ($searchValues) {
        foreach ($searchValues as $value) {
          $q->orWhere('name', 'like', "%{$value}%")
          ->orWhere('city','like', "%{$value}%")
          ->orWhere('country','like', "%{$value}%");
        }
      })->orderBy('name','asc');
    }


}
