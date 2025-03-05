<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'note' => $this->note,
            'from' => $this->from,  // التأكد من استرجاع القيم الصحيحة
            'to' => $this->to,
            'weight' => $this->weight,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
