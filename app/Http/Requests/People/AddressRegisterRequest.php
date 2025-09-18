<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class AddressRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'nullabe|string|max:255',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'uf' => 'required|string|max:2',
            'postal_code' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'number' => 'nullabe|string|max:20',
            'reference' => 'nullabe|string|max:255',
            'obs' => 'required|string',
            'main_address' => 'nullabe|boolean',
            'person_id' => 'required|exists:people,id|integer',
            'created_by' => 'required|exists:users,id|integer',
        ];
    }
}
