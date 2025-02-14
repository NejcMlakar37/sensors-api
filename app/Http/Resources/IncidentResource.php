<?php

namespace App\Http\Resources;

use App\Services\FormatterService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
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
            'type' => $this->resource->type,
            'value' => FormatterService::formatFloat($this->resource->value),
            'min' => FormatterService::formatFloat($this->resource->min),
            'max' => FormatterService::formatFloat($this->resource->max),
            'created_at' => Carbon::parse($this->resource->created_at)->format('H:i:s d.m.Y'),
        ];
    }
}
