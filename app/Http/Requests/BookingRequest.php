<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price' => 'required|numeric|min:0',
            'status' => 'in:pending,accepted,rejected,completed',
            'trip_id' => 'required|exists:trips,id',
            'ship_id' => 'required|exists:ships,id',
            'client_id' => 'required|exists:users,id',
        ];
    }
}
