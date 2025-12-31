<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event' => EventResource::make($this->whenLoaded('event')),
            'head_of_family' => HeadOfFamilyResource::make($this->whenLoaded('family')),
            'quantity' => $this->quantity,
            'total_price' => (float) (string) $this->total_price,
            'payment_status' => $this->payment_status,
        ];
    }
}
