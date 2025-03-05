<?php
namespace App\Http\Controllers\Api;

use App\Models\Trip;
use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Http\Resources\TripResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class TripController extends Controller
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
        $this->getClient(); // التحقق من المستخدم
        return TripResource::collection(Trip::all());
    }

    public function store(TripRequest $request)
    {
        $client = $this->getClient();

        $trip = Trip::create(array_merge($request->validated(), ['created_by' => $client->id]));

        return new TripResource($trip);
    }

    
    public function show($id)
    {
        $this->getClient();
        $trip = Trip::findOrFail($id);

        return new TripResource($trip);
    }

    public function update(TripRequest $request, $id)
    {
        $client = $this->getClient();
        $trip = Trip::findOrFail($id);

        if ($trip->created_by !== $client->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $trip->update($request->validated());

        return new TripResource($trip);
    }
    
    public function destroy($id)
    {
        $client = $this->getClient();
        $trip = Trip::findOrFail($id);

        if ($trip->created_by !== $client->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $trip->delete();

        return response()->json(['message' => 'Trip deleted successfully'], 200);
    }
}
