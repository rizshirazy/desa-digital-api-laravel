<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'thumbnail' => $this->thumbnail ? Storage::disk('public')->url($this->thumbnail) : null,
            'description' => $this->description,
            'price' => (float) (string) $this->price,
            'date' => $this->date?->format('Y-m-d'),
            'time' => $this->time,
            'is_active' => $this->is_active,
            'participants' => EventParticipantResource::collection($this->whenLoaded('participants')),
        ];
    }
}
