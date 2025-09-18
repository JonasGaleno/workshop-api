<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class PeopleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'fantasy_name' => 'required|string|max:255',
            'person_type' => 'required|string|max:1',
            'cpf_cnpj' => 'required|string|max:14',
            'ie_rg' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'company_id' => 'required|exists:companies,id|integer',
            'updated_by' => 'required|exists:users,id|integer',
        ];
    }
}
