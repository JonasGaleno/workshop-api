<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'min_stock' => 'nullable|numeric|min:0',
            'stock_amount' => 'nullable|numeric|min:0',
            'price_cost' => 'required|numeric|min:0',
            'price_sale' => 'required|numeric|min:0',
            'max_discount_perc' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'created_by' => 'required|integer|exists:users,id',
            'company_id' => 'required|integer|exists:companies,id',
        ];
    }
}
