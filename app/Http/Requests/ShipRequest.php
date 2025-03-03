<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,in_transit,delivered,canceled',
            'note' => 'nullable|string|max:255',
            'trip_id' => 'required|exists:trips,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
