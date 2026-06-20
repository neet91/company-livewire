<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('company')?->getKey();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('company-alpine', 'email')->ignore($companyId),
            ],
            'website' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ];
    }
}
