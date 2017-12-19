<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    //check role of user
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    //check if user is admin
    public function isAdmin()
    {
        return $this->roles()->where('name', 'admin')->exists();
    }

    //check if user is moderator
    public function isModerator()
    {
        return $this->roles()->where('name', 'moderator')->exists();
    }
    

}
