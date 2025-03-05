<?php 

namespace App\Http\Controllers\ApiController;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Ship;
use App\Models\Trip;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    private function getClient()
    {
        $client = JWTAuth::parseToken()->authenticate();
        if (!$client || $client->role !== 'client') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $client;
    }

    public function index()
    {
        $client = $this->getClient();
        $bookings = Booking::where('client_id', $client->id)->get();
        return BookingResource::collection($bookings);
    }

    public function store(BookingRequest $request)
    {
        $client = $this->getClient();

        $isOwner = Ship::where('id', $request->ship_id)->where('client_id', $client->id)->exists()
                    || Trip::where('id', $request->trip_id)->where('client_id', $client->id)->exists();

        if (!$isOwner) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking = Booking::create(array_merge($request->validated(), ['client_id' => $client->id]));
        return new BookingResource($booking);
    }

    public function show($id)
    {
        $client = $this->getClient();
        $booking = Booking::where('id', $id)->where('client_id', $client->id)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return new BookingResource($booking);
    }

    public function update(BookingRequest $request, $id)
    {
        $client = $this->getClient();
        $booking = Booking::where('id', $id)->where('client_id', $client->id)->first();

        if (!$booking) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking->update($request->validated());
        return new BookingResource($booking);
    }

    public function destroy($id)
    {
        $client = $this->getClient();
        $booking = Booking::where('id', $id)->where('client_id', $client->id)->first();

        if (!$booking) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }
}
