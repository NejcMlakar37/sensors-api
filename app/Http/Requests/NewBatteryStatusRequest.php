<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewBatteryStatusRequest extends FormRequest
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
            'sensor_id' => ['required', 'numeric', 'exists:sensors,id'],
            'status' => ['required', 'numeric', 'between:0.00,100.00'],
        ];
    }
}
