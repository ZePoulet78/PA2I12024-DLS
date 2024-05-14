<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'role',
        'firstname',
        'lastname',
        'avatar',
        'tel',
        'isRegistered',
        'authToken'
    ];


    protected $hidden = [
        'password',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'has_roles');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'make_activity');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    
}
