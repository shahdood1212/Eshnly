<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Illuminate\Http\Request;
use App\Http\Requests\ShipRequest;
use App\Http\Resources\ShipResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShipController extends Controller
{
       private function getClient()
    {
        $client = JWTAuth::parseToken()->authenticate();

        if (!$client ) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $client;
    }

    public function index(Request $request)
    {
        $this->getClient(); 
        $shipments = Ship::with('trip')->latest()->paginate(10);
        return ShipResource::collection($shipments);
    }

    public function store(ShipRequest $request)
    {
        $client = $this->getClient();
        $validatedData = $request->validated();

        $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];
        $validatedData['created_by'] = $client->id;

        $ship = Ship::create($validatedData);

        return response()->json([
            'message' => 'Shipment created successfully',
            'data' => new ShipResource($ship)
        ], 201);
    }

    public function show($id)
    {
        $this->getClient();
        $ship = Ship::with('trip')->find($id);

        if (!$ship) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        return new ShipResource($ship);
    }

    public function update(ShipRequest $request, $id)
    {
        $client = $this->getClient();
        $ship = Ship::find($id);

        if (!$ship || $ship->created_by !== $client->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validated();
        $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];

        $ship->update($validatedData);

        return response()->json([
            'message' => 'Shipment updated successfully',
            'data' => new ShipResource($ship)
        ]);
    }

    public function destroy($id)
    {
        $client = $this->getClient();
        $ship = Ship::find($id);

        if (!$ship || $ship->created_by !== $client->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $ship->delete();

        return response()->json(['message' => 'Shipment deleted successfully']);
    }
}
