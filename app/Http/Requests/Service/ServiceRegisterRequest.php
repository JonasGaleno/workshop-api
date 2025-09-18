<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'type' => 'nullable|string|max:1',
            'price_sale' => 'required|numeric|min:0',
            'max_discount_perc' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'duration' => 'nullable|integer',
            'created_by' => 'required|integer|exists:users,id',
            'company_id' => 'required|integer|exists:companies,id',
        ];
    }
}
