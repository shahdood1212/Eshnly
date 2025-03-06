<?php
namespace App\Http\Controllers\ApiController;

use App\Models\Trip;
use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Http\Resources\TripResource;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;

class TripController extends Controller
{
    
    private function getClient()
    {
        try{
        $client = JWTAuth::parseToken()->authenticate();

        if (!$client ) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $client;
    }
    catch(\Exception $e){
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}

    
    public function index()
    {
        $client = $this->getClient();
        if ($client instanceof JsonResponse) return $client;

        return TripResource::collection(Trip::where('created_by', $client->id)->get());
    }

    public function store(TripRequest $request)
    {
        $client = $this->getClient();
        if ($client instanceof JsonResponse) return $client;

        $trip = Trip::create(array_merge($request->validated(), ['created_by' => $client->id]));

        return new TripResource($trip);
    }

    
    public function show($id)
    { 
        $client = $this->getClient();
        if ($client instanceof JsonResponse) return $client;

        $trip = Trip::where('id', $id)->where('created_by', $client->id)->first();

        if (!$trip) {
            return response()->json(['message' => 'Trip not found or unauthorized'], 404);
        }

        return new TripResource($trip);
    }

    public function update(TripRequest $request, $id)
    {
        $client = $this->getClient();
        if ($client instanceof JsonResponse) return $client;

        $trip = Trip::where('id', $id)->where('created_by', $client->id)->first();

        if (!$trip) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $trip->update($request->validated());

        return new TripResource($trip);

    }
    
    public function destroy($id)
    {
        $client = $this->getClient();
        if ($client instanceof JsonResponse) return $client;

        $trip = Trip::where('id', $id)->where('created_by', $client->id)->first();

        if (!$trip) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $trip->delete();

        return response()->json(['message' => 'Trip deleted successfully'], 200);
    }
}
