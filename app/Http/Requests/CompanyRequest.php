<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:companies,name', 'max:124'],
            'address' => ['required', 'string', 'max:124'],
            'city' => ['required', 'string', 'max:50'],
            'postcode' => ['required', 'string', 'max:4', 'min:4'],
            'country' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies,contact_email'],
        ];
    }
}
