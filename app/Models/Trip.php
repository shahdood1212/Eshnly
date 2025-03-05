<?php

    namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'From', 'To', 'departure_date', 'arrival_date', 
        'free_weight', 'status', 'created_by'
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'created_by');
    }

    public function shipments()
    {
        return $this->hasMany(Ship::class, 'trip_id');
    }
    
}
