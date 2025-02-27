<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;

    protected $fillable = [
        'note', 'from', 'to', 'weight', 'quantity', 'status', 'image', 'created_by', 'trip_id'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
