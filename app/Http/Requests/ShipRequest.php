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
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string|in:pending,in_transit,delivered',
            'created_by' => 'required|exists:users,id'
        ];
    }
    
}
