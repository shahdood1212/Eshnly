<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Ship extends Model
// {
//     use HasFactory;

//     protected $table = 'ships';

//     protected $fillable = [
//         'note', 'from', 'to', 'weight', 'price', 'quantity',
//         'total_price', 'total_weight', 'status', 'image', 'created_by', 'trip_id'
//     ];

//     protected $casts = [
//         'from' => 'string',
//         'to' => 'string',
//     ];

//     public function getImageAttribute($value)
//     {
//         return trim($value);
//     }

//     public function trip()
//     {
//         return $this->belongsTo(Trip::class, 'trip_id');
//     }

//     public function user()
//     {
//         return $this->belongsTo(User::class, 'created_by');
//     }
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;

    protected $table = 'ships';

    protected $fillable = [
        'note', 'from', 'to', 'weight', 'price', 'quantity',
        'total_price', 'total_weight', 'status', 'image', 'created_by', 'trip_id'
    ];

    public function getImageAttribute($value)
    {
        return trim($value);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
