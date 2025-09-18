<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'expertise' => 'required|string|max:255',
            'service_comission_perc' => 'required|numeric|min:0',
            'company_id' => 'required|exists:companies,id|integer',
            'updated_by' => 'required|exists:users,id|integer',
        ];
    }
}
