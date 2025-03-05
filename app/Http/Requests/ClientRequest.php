<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $this->route('client'),
            'phone' => 'required|string|max:15',
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:6';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['password'] = 'sometimes|string|min:6';
        }

        return $rules;
    }
}
