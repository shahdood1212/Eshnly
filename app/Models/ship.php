<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'weight',
     'quantity', 'price', 'total_price', 'total_weight',
      'status', 'note', 'image'];

}
