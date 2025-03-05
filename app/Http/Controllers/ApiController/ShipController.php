<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Illuminate\Http\Request;
use App\Http\Requests\ShipRequest;
use App\Http\Resources\ShipResource;

class ShipController extends Controller
{
    public function index(Request $request)
    {
        $shipments = Ship::with(['trip', 'user'])->latest()->paginate(10);
        return ShipResource::collection($shipments);
    }

    public function store(ShipRequest $request)
    {
        $validatedData = $request->validated();

        // التأكد من إدخال `from` و `to`
        if (empty($validatedData['from']) || empty($validatedData['to'])) {
            return response()->json(['message' => 'From and To fields are required'], 422);
        }

        // حساب السعر الإجمالي
        $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];

        $ship = Ship::create($validatedData);

        return response()->json([
            'message' => 'Shipment created successfully',
            'data' => new ShipResource($ship)
        ], 201);
    }

    public function show($id)
    {
        $ship = Ship::with(['trip', 'user'])->find($id);
        if (!$ship) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }
        return new ShipResource($ship);
    }

    public function update(ShipRequest $request, $id)
    {
        $ship = Ship::find($id);
        if (!$ship) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        $validatedData = $request->validated();

        if (empty($validatedData['from']) || empty($validatedData['to'])) {
            return response()->json(['message' => 'From and To fields are required'], 422);
        }

        $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];
        $ship->update($validatedData);

        return response()->json([
            'message' => 'Shipment updated successfully',
            'data' => new ShipResource($ship)
        ]);
    }

    public function destroy($id)
    {
        $ship = Ship::find($id);
        if (!$ship) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        $ship->delete();
        return response()->json(['message' => 'Shipment deleted successfully']);
    }
}
