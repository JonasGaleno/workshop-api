<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'created_by' => 'required|exists:users,id|integer',
        ];
    }
}
