<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class EmailUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'nullabe|string|max:255',
            'email' => 'required|email|string|max:255',
            'main_contact' => 'nullabe|boolean',
            'person_id' => 'required|exists:people,id|integer',
            'updated_by' => 'required|exists:users,id|integer',
        ];
    }
}
