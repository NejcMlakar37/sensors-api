<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource['user']->id,
            'name' => $this->resource['user']->username,
            'email' => $this->resource['user']->email,
            'company' => new CompanyResource($this->resource['user']->company),
            'role' => new RoleResource($this->resource['user']->role),
            'token' => $this->resource['token'],
        ];
    }
}
