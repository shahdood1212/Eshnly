<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $primarykey = 'id';

    protected $fillable = [
        'name', 
        'admin_image',
        'phone_number',
        'email',
        'password'
    ];
}