<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceTaxUpdateRequest extends FormRequest
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
            'updated_by' => 'required|exists:users,id|integer',
        ];
    }
}
