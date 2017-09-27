<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    
    public function result()
    {
        return $this->belongsToMany(Result::class)->withTimestamps();
    }
}
