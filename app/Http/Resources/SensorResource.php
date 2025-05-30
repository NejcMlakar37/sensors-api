<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SensorResource extends JsonResource
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
            'name' => $this->resource->name,
            'company' => $this->resource->company_id,
            'location' => $this->resource->location,
            'position' => $this->resource->position,
            'battery' => $this->resource->currentBattery? $this->resource->currentBattery->status : '/',
            'active_temp_alert' => $this->resource->active_temp_alarm,
            'active_humid_alert' => $this->resource->active_humid_alert,
        ];
    }
}
