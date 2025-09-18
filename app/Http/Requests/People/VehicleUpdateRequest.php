<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullabe|string|max:255',
            'brand' => 'required|string|max:100',
            'tag' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'model' => 'required|string|max:100',
            'year' => 'required|digits:4|integer|min:' . date('Y'),
            'engine' => 'nullable|string|max:50',
            'number' => 'nullabe|string|max:20',
            'obs' => 'required|string',
            'person_id' => 'required|exists:people,id|integer',
            'updated_by' => 'required|exists:users,id|integer',
        ];
    }
}
