<?php

    namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'from', 'to', 'departure_date', 'arrival_date',
        'free_weight', 'status', 'created_by'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function shipments()
    {
        return $this->hasMany(Ship::class, 'trip_id');
    }
    
}
