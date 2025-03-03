<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShipRequest;

class ShipController extends Controller
{
    public function index()
    {
        $shipments = Ship::orderBy('created_at', 'desc')->get();
        return response()->json($shipments, 200);
    }

    
    public function store(ShipRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];
        $validatedData['total_weight'] = $validatedData['weight'] * $validatedData['quantity'];
        $validatedData['added_by'] = Auth::id();
    
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('shipments', 'public');
        }
    
        // طباعة البيانات للتحقق
        dd($validatedData);
    
        $ship = Ship::create($validatedData);
    
        return response()->json(['message' => 'Shipment created successfully', 'data' => $ship], 201);
    }
    

    public function show($id)
    {
        $ship = Ship::find($id);
        if (!$ship) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }
        return response()->json($ship, 200);
    }

    public function update(ShipRequest $request, $id)
    {
        $ship = Ship::find($id);
        if (!$ship) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        $validatedData = $request->validated();
        $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];
        $validatedData['total_weight'] = $validatedData['weight'] * $validatedData['quantity'];

        if ($request->hasFile('image')) {
            if ($ship->image) {
                Storage::disk('public')->delete($ship->image);
            }
            $validatedData['image'] = $request->file('image')->store('shipments', 'public');
        }

        $ship->update($validatedData);

        return response()->json(['message' => 'Shipment updated successfully', 'data' => $ship], 200);
    }

    public function destroy($id)
    {
        $ship = Ship::find($id);
        if (!$ship) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        if ($ship->image) {
            Storage::disk('public')->delete($ship->image);
        }

        $ship->delete();

        return response()->json(['message' => 'Shipment deleted successfully.'], 200);
    }
}
