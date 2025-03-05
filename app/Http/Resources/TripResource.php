<?php

namespace App\Http\Resources;

use App\Http\Resources\ShipResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'id' => $this->id,
                'From' => $this->From,
                'To' => $this->To,
                'departure_date' => $this->departure_date,
                'arrival_date' => $this->arrival_date,
                'free_weight' => $this->free_weight,
                'status' => $this->status,
                'created_by' => $this->client,
                //'created_by' => new ClientResource($this->client),
                'shipments' => ShipResource::collection($this->shipments),
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),            
        ];
    }
}
