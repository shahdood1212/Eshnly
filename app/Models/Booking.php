<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'status', 'trip_id', 'ship_id', 'client_id'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
