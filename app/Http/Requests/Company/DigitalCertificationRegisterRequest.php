<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class DigitalCertificationRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'nullable|string|max:255',
            'certificate_file' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'boolean',
            'company_id' => 'nullable|exists:companies,id|max:100',
            'created_by' => 'required|exists:users,id|integer',
        ];
    }
}
