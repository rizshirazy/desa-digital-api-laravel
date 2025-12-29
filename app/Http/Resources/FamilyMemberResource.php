<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FamilyMemberResource extends JsonResource
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
            'head_of_family' => HeadOfFamilyResource::make($this->whenLoaded('headOfFamily')),
            'user' => UserResource::make($this->user),
            'profile_picture' => $this->profile_picture
                ? Storage::disk('public')->url($this->profile_picture)
                : null,
            'identity_number' => $this->identity_number,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'phone_number' => $this->phone_number,
            'occupation' => $this->occupation,
            'marital_status' => $this->marital_status,
            'relation' => $this->relation,
        ];
    }
}
