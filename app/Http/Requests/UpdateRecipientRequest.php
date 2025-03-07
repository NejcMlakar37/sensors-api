<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipientRequest extends FormRequest
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
            'recipient_id' => ['required', 'numeric', 'exists:email_recipients,id'],
            'sensor_id' => ['required', 'numeric', 'exists:sensors,id'],
            'email' => ['required', 'email']
        ];
    }
}
