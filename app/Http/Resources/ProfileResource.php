<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProfileResource extends JsonResource
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
            'about' => $this->about,
            'headman' => $this->headman,
            'people' => $this->people,
            'agricultural_area' => (float)(string) $this->agricultural_area,
            'total_area' => (float)(string) $this->total_area,
            'images' => ProfileImageResource::collection($this->images),
        ];
    }
}
