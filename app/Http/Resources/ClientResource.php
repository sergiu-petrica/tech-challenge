<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
            'address' => $this->resource->address,
            'city' => $this->resource->city,
            'postcode' => $this->resource->postcode,
            'user_id' => $this->resource->user_id,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'user' => $this->resource->relationLoaded('user')
                ? UserResource::make($this->resource->user)
                : null,
            'bookings' => $this->resource->relationLoaded('bookings')
                ? BookingResource::collection($this->resource->bookings)
                : null,
            'journals' => $this->resource->relationLoaded('journals')
                ? JournalResource::collection($this->resource->journals)
                : null,
            'bookings_count' => $this->resource->bookings_count,
            'url' => $this->resource->url,
        ];
    }
}
