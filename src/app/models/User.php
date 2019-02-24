<?php

namespace App\Models;

use App\Traits\UserRoles;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, UserRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Helper function to determine if the user has been
     * assigned the admin role
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is('admin');
    }

    /**
     * Each user can have many roles within the software
     *
     * @return \App\Models\Role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
