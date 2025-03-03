<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('bookings.index', compact('bookings'));
    }
    
    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'ship_id' => 'required|exists:ships,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,accepted,rejected,completed',
        ]);

        Booking::create($validated);

        return redirect()->route('bookings.index')->with('success', 'Booking added successfully.');
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'ship_id' => 'required|exists:ships,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,accepted,rejected,completed',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
