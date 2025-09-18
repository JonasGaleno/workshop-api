<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'nullabe|string|max:255',
            'number' => 'required|string|max:20',
            'main_number' => 'nullabe|boolean',
            'person_id' => 'required|exists:people,id|integer',
            'created_by' => 'required|exists:users,id|integer',
        ];
    }
}
