<?php

namespace App\Http\Resources;

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
            'type' => $this->resource->type,
            'value' => $this->resource->value,
            'min' => $this->resource->min,
            'max' => $this->resource->max,
            'created_at' => $this->resource->created_at->format('H:i:s d.m.Y'),
        ];
    }
}
