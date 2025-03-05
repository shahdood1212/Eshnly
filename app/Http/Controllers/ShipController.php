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
            $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $validated['image'] = $request->file('image')->storeAs('shipments', $filename, 'public');
        }

        Ship::create($validated);

        return redirect()->route('ships.index')->with('success', 'Shipment added successfully.');
    }

    public function show(Ship $ship)
    {
        return view('ships.show', compact('ship'));
    }

    public function edit($id)
    {
        $ship = Ship::findOrFail($id);
        return view('ships.edit', compact('ship'));
    }

    public function update(Request $request, Ship $ship)
    {
        $validated = $request->validate([
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,in_transit,delivered,canceled',
            'note' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $validated['total_price'] = isset($validated['price'], $validated['quantity']) ? $validated['price'] * $validated['quantity'] : 0;
        $validated['total_weight'] = isset($validated['weight'], $validated['quantity']) ? $validated['weight'] * $validated['quantity'] : 0;
         
        if ($request->hasFile('image')) {
            if ($ship->image && Storage::disk('public')->exists($ship->image)) {
                Storage::disk('public')->delete($ship->image);
            }
        
            $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $validated['image'] = $request->file('image')->storeAs('shipments', $filename, 'public');
        }
        
        $ship->update($validated);
        
        return redirect()->route('ships.index')->with('success', 'Shipment updated successfully.');
    }        
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        return response()->json([
            'message' => 'image uploaded!',
            'path' => Storage::url($path),
        ]);
    }

    public function destroy(Ship $ship)
    {
        if ($ship->image && Storage::disk('public')->exists($ship->image)) {
            Storage::disk('public')->delete($ship->image);
        }

        $ship->delete();
        return redirect()->route('ships.index')->with('success', 'Shipment deleted successfully.');
    }
}
