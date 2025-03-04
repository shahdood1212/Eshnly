<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ShipResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'weight' => $this->weight,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total_price' => $this->total_price,
            'total_weight' => $this->total_weight,
            'status' => $this->status,
            'note' => $this->note,
            'trip_id' => $this->trip_id,
            'image_url' => $this->image ? asset(Storage::url($this->image)) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'trip' => $this->trip,
            'created_by' => $this->user 
        ];
    }
}
