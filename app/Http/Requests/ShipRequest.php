<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipRequest
{
    public static function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'nullable|string|max:255',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string|in:pending,in_transit,delivered',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trip_id' => 'nullable|exists:trips,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return null;
    }
}
