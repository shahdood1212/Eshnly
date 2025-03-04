<?php

// namespace App\Http\Controllers\ApiController;

// use App\Http\Controllers\Controller;
// use App\Models\Ship;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Http\Request;
// use App\Http\Requests\ShipRequest;
// use App\Http\Resources\ShipResource;

// class ShipController extends Controller
// {
//     public function index()
//     {
//         $shipments = Ship::with(['trip', 'user'])->latest()->get();
//         return ShipResource::collection($shipments);
//     }

//     public function store(Request $request)
//     {
//         // التحقق من صحة البيانات
//         $validationResponse = ShipRequest::validate($request);
//         if ($validationResponse) {
//             return $validationResponse;
//         }

//         try {
//             $validatedData = $request->all();
//             $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];
//             $validatedData['total_weight'] = $validatedData['weight'] * $validatedData['quantity'];
//             $validatedData['created_by'] = Auth::id();

//             if (!$validatedData['created_by']) {
//                 return response()->json(['error' => 'Unauthorized'], 401);
//             }

//             if ($request->hasFile('image')) {
//                 $validatedData['image'] = $request->file('image')->store('shipments', 'public');
//             }

//             $ship = Ship::create($validatedData);
//             return new ShipResource($ship);
//         } catch (\Exception $e) {
//             Log::error('Error creating shipment:', ['error' => $e->getMessage()]);
//             return response()->json(['error' => 'Something went wrong!'], 500);
//         }
//     }

//     public function show($id)
//     {
//         $ship = Ship::with(['trip', 'user'])->find($id);
//         if (!$ship) {
//             return response()->json(['message' => 'Shipment not found'], 404);
//         }
//         return new ShipResource($ship);
//     }

//     public function update(Request $request, $id)
//     {
//         $ship = Ship::find($id);
//         if (!$ship) {
//             return response()->json(['message' => 'Shipment not found'], 404);
//         }

//         // التحقق من صحة البيانات
//         $validationResponse = ShipRequest::validate($request);
//         if ($validationResponse) {
//             return $validationResponse;
//         }

//         try {
//             $validatedData = $request->all();
//             $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];
//             $validatedData['total_weight'] = $validatedData['weight'] * $validatedData['quantity'];

//             if ($request->hasFile('image')) {
//                 if ($ship->image) {
//                     Storage::disk('public')->delete($ship->image);
//                 }
//                 $validatedData['image'] = $request->file('image')->store('shipments', 'public');
//             }

//             $ship->update($validatedData);
//             return new ShipResource($ship);
//         } catch (\Exception $e) {
//             Log::error('Error updating shipment:', ['error' => $e->getMessage()]);
//             return response()->json(['error' => 'Something went wrong!'], 500);
//         }
//     }

//     public function destroy($id)
//     {
//         $ship = Ship::find($id);
//         if (!$ship) {
//             return response()->json(['message' => 'Shipment not found'], 404);
//         }

//         if ($ship->image) {
//             Storage::disk('public')->delete($ship->image);
//         }

//         $ship->delete();
//         return response()->json(['message' => 'Shipment deleted successfully.'], 200);
//     }
// }


namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\ShipRequest;
use App\Http\Resources\ShipResource;
use App\Filters\ShipFilter;

class ShipController extends Controller
{

    public function index(Request $request)
    {
        $query = Ship::with(['trip', 'user']);
        
        // Apply filtering
        $filter = new ShipFilter($request);
        $query = $filter->apply($query);
    
        // Paginate and return results
        $shipments = $query->latest()->paginate(10);
    
        return ShipResource::collection($shipments);
    }
    
    public function store(Request $request)
    {
        $validationResponse = ShipRequest::validate($request);
        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            Log::info('Authenticated User ID:', ['user_id' => Auth::id()]);

            $validatedData = $request->all();
            $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];
            $validatedData['total_weight'] = $validatedData['weight'] * $validatedData['quantity'];
            $validatedData['created_by'] = Auth::id() ?? $request->input('created_by');

            if ($request->hasFile('image')) {
                $validatedData['image'] = $request->file('image')->store('shipments', 'public');
            }

            $ship = Ship::create($validatedData);
            return new ShipResource($ship);
        } catch (\Exception $e) {
            Log::error('Error creating shipment:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $ship = Ship::with(['trip', 'user'])->find($id);
        if (!$ship) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }
        return new ShipResource($ship);
    }

    public function update(Request $request, $id)
    {
        $ship = Ship::find($id);
        if (!$ship) {
            return response()->json(['message' => 'Shipment not found'], 404);
        }

        // التحقق من صحة البيانات
        $validationResponse = ShipRequest::validate($request);
        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $validatedData = $request->all();
            $validatedData['total_price'] = $validatedData['price'] * $validatedData['quantity'];
            $validatedData['total_weight'] = $validatedData['weight'] * $validatedData['quantity'];

            if ($request->hasFile('image')) {
                if ($ship->image) {
                    Storage::disk('public')->delete($ship->image);
                }
                $validatedData['image'] = $request->file('image')->store('shipments', 'public');
            }

            $ship->update($validatedData);
            return new ShipResource($ship);
        } catch (\Exception $e) {
            Log::error('Error updating shipment:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
