<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ship;
use Illuminate\Support\Facades\Storage;

class ShipController extends Controller
{
    public function index()
    {
        $shipments = Ship::all();
        return view('ships.index', compact('shipments'));
    }

    public function create()
    {
        return view('ships.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'shipment_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'weight' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ship = new Ship();
        $ship->fill($request->except('image'));
        $ship->total_price = $request->quantity * $request->price;
        $ship->total_weight = $request->quantity * $request->weight;
        $ship->status = 'pending';
        $ship->added_by = auth()->id(); // تخزين المستخدم الذي أضاف الشحنة
        $ship->image = $this->handleImageUpload($request, $ship);

        $ship->save();

        return redirect()->route('ships.index')->with('success', 'Shipment added successfully');
    }

    public function show($id)
    {
        $ship = Ship::findOrFail($id);
        return view('ships.show', compact('ship'));
    }

    public function edit($id)
    {
        $ship = Ship::findOrFail($id);
        return view('ships.edit', compact('ship'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'shipment_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'weight' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,shipped,delivered',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ship = Ship::findOrFail($id);
        $ship->fill($request->except('image'));
        $ship->image = $this->handleImageUpload($request, $ship);

        $ship->save();

        return redirect()->route('ships.index')->with('success', 'Shipment updated successfully');
    }

    public function destroy($id)
    {
        try {
            $ship = Ship::findOrFail($id);

            if ($ship->image) {
                Storage::disk('public')->delete($ship->image);
            }

            $ship->delete();

            return redirect()->route('ships.index')->with('success', 'Shipment deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('ships.index')->with('error', 'Failed to delete shipment: ' . $e->getMessage());
        }
    }

    private function handleImageUpload(Request $request, $ship)
    {
        if ($request->hasFile('image')) {
            if ($ship->image) {
                Storage::disk('public')->delete($ship->image);
            }
            return $request->file('image')->store('ships', 'public');
        }
        return $ship->image;
    }
}
