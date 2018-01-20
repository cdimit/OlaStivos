<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionSeries extends Model
{

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    public function competition()
    {
        return $this->hasMany('App\Competition');
    }

    public function competitions()
    {
        return $this->belongsToMany(Competition::class);
    }

}
