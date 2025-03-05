<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Trip;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TripResource;
use App\Http\Resources\ShipResource;
use Illuminate\Http\Response;

class TripController extends Controller
{
    
    public function index()
    {
        $trips = Trip::all();
        return TripResource::collection($trips);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'From' => 'required|string',
            'To' => 'required|string',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date',
            'free_weight' => 'required|numeric',
            'status' => 'in:pending,canceled,completed',
            'created_by' => 'required|exists:clients,id'
        ]);

        $trip = Trip::create($request->all());
        return new TripResource($trip);
    }

    
    public function show(string $id)
    {
        $trip = Trip::find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }
        return new TripResource($trip);
    }

    
    public function update(Request $request, string $id)
    {
        $trip = Trip::find($id);
        $request->validate([
            'From' => 'string',
            'To' => 'string',
            'departure_date' => 'date',
            'arrival_date' => 'date',
            'free_weight' => 'numeric',
            'status' => 'in:pending,canceled,completed',
            'created_by' => 'exists:clients,id'
        ]);
        $trip->update($request->all());
        return new TripResource($trip); 
    }

    
    public function destroy(string $id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();
        return response()->json(['message' => 'Trip deleted successfully'], 200);
    }
}
