<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'start' => $this->resource->start,
            'end' => $this->resource->end,
            'notes' => $this->resource->notes,
            'client_id' => $this->resource->client_id,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'client' => $this->resource->relationLoaded('client')
                ? ClientResource::make($this->resource->client)
                : null,
        ];
    }
}
