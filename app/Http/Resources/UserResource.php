<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'email' => $this->resource->name,
            'email_verified_at' => $this->resource->email_verified_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'clients' => $this->resource->relationLoaded('clients')
                ? ClientResource::collection($this->resource->clients)
                : null,
        ];
    }
}
