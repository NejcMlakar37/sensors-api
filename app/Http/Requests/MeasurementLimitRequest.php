<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeasurementLimitRequest extends FormRequest
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
        $decimalFormat = 'decimal:0,2';

        return [
            'sensor_id' => ['required', 'numeric', 'exists:sensors,id'],
            'min_temp' => ['required', $decimalFormat],
            'max_temp' => ['required', $decimalFormat],
            'min_humidity' => ['required', $decimalFormat],
            'max_humidity' => ['required', $decimalFormat],
        ];
    }
}
