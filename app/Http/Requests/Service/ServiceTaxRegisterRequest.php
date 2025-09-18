<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceTaxRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => 'required|integer|exists:services,id',
            'tax_id' => 'required|integer|exists:taxes,id',
            'uf' => 'nullable|string|max:2',
            'created_by' => 'required|integer|exists:users,id',
        ];
    }
}
