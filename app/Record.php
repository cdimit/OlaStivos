<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    
    public function results()
    {
        return $this->belongsToMany(Result::class)->withTimestamps();
    }
}
