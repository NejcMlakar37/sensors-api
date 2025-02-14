<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementLimitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'sensor' => new SensorResource($this->resource->sensor),
            'min_temp' => number_format((float)$this->resource->min_temp, 2, '.', ''),
            'max_temp' => number_format((float)$this->resource->max_temp, 2, '.', ''),
            'min_humidity' => number_format((float)$this->resource->min_humidity, 2, '.', ''),
            'max_humidity' => number_format((float)$this->resource->max_humidity, 2, '.', ''),
        ];
    }
}
