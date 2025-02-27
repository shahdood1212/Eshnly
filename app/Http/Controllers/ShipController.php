<?php
namespace App\Http\Controllers;

use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShipController extends Controller
{
    public function index()
    {
        $shipments = Ship::orderBy('created_at', 'desc')->get();
        return view('ships.index', compact('shipments'));
    }

    public function create()
    {
        return view('ships.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string|in:pending,in_transit,delivered,canceled', 
            'note' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['total_price'] = $validated['price'] * $validated['quantity'];
        $validated['total_weight'] = $validated['weight'] * $validated['quantity'];
        $validated['added_by'] = auth()->id();
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('shipments', 'public');
        }

        Ship::create($validated);

        return redirect()->route('ships.index')->with('success', 'Shipment added successfully.');
    }

    public function show(Ship $ship)
    {
        return view('ships.show', compact('ship'));
    }

    public function edit(Ship $ship)
    {
        return view('ships.edit', compact('ship'));
    }

    public function update(Request $request, Ship $ship)
    {
        $validatedData = $request->validate([
            'from' => 'required|string',
            'to' => 'required|string',
            'weight' => 'required|numeric',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required|string',
            'note' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];
        
        $ship->update($validatedData);
        
        $validatedData['total_weight'] = $validatedData['weight'] * $validatedData['quantity'];

        if ($request->hasFile('image')) {
            if ($ship->image) {
                Storage::disk('public')->delete($ship->image);
            }
            $validated['image'] = $request->file('image')->store('shipments', 'public');
        }

        $ship->update($validated);

        return redirect()->route('ships.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy(Ship $ship)
    {
        if ($ship->image) {
            Storage::disk('public')->delete($ship->image);
        }
        
        $ship->delete();

        return redirect()->route('ships.index')->with('success', 'Shipment deleted successfully.');
    }
}
