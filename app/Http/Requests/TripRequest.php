<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{
    public function authorize()
    {
        return true; // يمكنك تخصيص التحقق من الصلاحيات هنا
    }

    public function rules()
    {
        return [
            'From' => 'required|string',
            'To' => 'required|string',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date|after_or_equal:departure_date',
            'free_weight' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,canceled,completed',
        ];
    }
}
