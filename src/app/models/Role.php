<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Each role can belong to many users
     *
     * @return \App\Models\User
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
