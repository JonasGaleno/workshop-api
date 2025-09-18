<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'updated_by' => 'required|exists:users,id|integer',
        ];
    }
}
