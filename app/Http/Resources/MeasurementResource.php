<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $time = Carbon::parse($this->resource->timestamp);

        return [
            'id' => $this->resource->id,
            'sensor' => new SensorResource($this->resource->sensor),
            'temperature' => number_format((float)$this->resource->temperature, 2, '.', ''),
            'humidity' => number_format((float)$this->resource->humidity, 2, '.', ''),
            'timestamp' => $time->addHours($time->offsetHours)->format('Y-m-d H:i:s'),
        ];
    }
}
