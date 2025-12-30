<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SocialAssistanceResource extends JsonResource
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
            'category' => $this->category,
            'amount' => $this->amount,
            'provider' => $this->provider,
            'description' => $this->description,
            'is_available' => $this->is_available,
            'recipients' => SocialAssistanceRecipientResource::collection($this->whenLoaded('recipients')),
        ];
    }
}
