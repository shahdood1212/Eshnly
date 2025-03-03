<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;
    protected $table = 'ships';
    protected $fillable = [
        'from', 'to', 'weight', 'quantity', 'price', 'total_price', 'total_weight', 'image', 'status', 'note', 'created_by', 'trip_id'
    ];
    
    public function getImageAttribute($value)
    {
        return trim($value);
    }
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
    public function setTotalPriceAttribute()
    {
        $this->attributes['total_price'] = $this->attributes['price'] * $this->attributes['quantity'];
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
