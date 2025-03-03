<?php
namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::all();
        $trips = Trip::with('user')->get();
        return view('trips.index', compact('trips'));    }

    public function show($id)
    {
        $trip = Trip::findOrFail($id);
        return view('trips.show', compact('trip'));
    }

    public function create()
    {
        return view('trips.create');
    }

    
        public function store(Request $request)
        {
            $validated = $request->validate([
                'from' => 'required|string|max:255',
                'to' => 'required|string|max:255',
                'departure_date' => 'required|date',
                'arrival_date' => 'required|date|after_or_equal:departure_date',
                'free_weight' => 'required|numeric|min:0',
                'status' => 'required|string|in:pending,ongoing,completed,canceled',
                'created_by' => 'required|exists:users,id',
            ]);
        
            Trip::create($validated);
            return redirect()->route('trips.index')->with('success', 'Trip created successfully.');
        }
        
        public function update(Request $request, $id)
{
    $trip = Trip::findOrFail($id);

    $validatedData = $request->validate([
        'from' => 'required|string|max:255',
        'to' => 'required|string|max:255',
        'free_weight' => 'required|numeric',
        'status' => 'required|string|in:pending,in_transit,delivered,canceled',
        'note' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $trip->update($validatedData);

    return redirect()->route('trips.index')->with('success', 'Trip updated successfully.');
}


    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        return view('trips.edit', compact('trip'));
    }




    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();
        return redirect()->route('trips.index')->with('success', 'Trip deleted successfully.');
    }
}
