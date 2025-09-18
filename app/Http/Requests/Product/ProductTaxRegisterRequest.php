<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductTaxRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'tax_id' => 'required|integer|exists:taxes,id',
            'uf' => 'nullable|string|max:2',
            'created_by' => 'required|integer|exists:users,id',
        ];
    }
}
