<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'fantasy_name' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18',
            'registration_state_ie' => 'required|string|max:50',
            'email' => 'required|string|email|max:255',
            'number' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'uf' => 'nullable|string|max:2',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'obs' => 'nullable|string',
            'created_by' => 'required|exists:users,id|integer',
        ];
    }
}
