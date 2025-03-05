<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Client extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'phone'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];

    // علاقة One-to-Many مع `trips`
    public function trips()
    {
        return $this->hasMany(Trip::class, 'created_by');
    }

    // علاقة One-to-Many مع `ships`
    public function ships()
    {
        return $this->hasMany(Ship::class, 'created_by');
    }
}
