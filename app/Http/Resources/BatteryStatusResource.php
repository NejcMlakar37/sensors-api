<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatteryStatusResource extends JsonResource
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
            'sensor_id' => $this->resource->sensor_id,
            'status' => $this->resource->status,
            'created_at' => Carbon::parse($this->resource->created_at)->addHours(2)->format('Y-m-d'),
        ];
    }
}
