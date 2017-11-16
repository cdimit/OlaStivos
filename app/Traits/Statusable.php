<?php

namespace App\Traits;

trait Statusable
{

 	public function scopePublished($query)
  	{
  		 // status 1 == true means published
  		return $query->where('status',1);
  	}

 	public function scopePending($query)
  	{
  		// status 0 == false means still pending
  		return $query->where('status',0);
  	}

	public function isPublished()
	{
		if ($this->status == 1){
			return true;
		}
	    return false;
	}

	public function isPending()
	{
		if ($this->status == 0){
			return true;
		}
	    return false;
	}

}

