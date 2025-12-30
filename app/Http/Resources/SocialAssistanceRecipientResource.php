<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SocialAssistanceRecipientResource extends JsonResource
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
            'social_assistance' => SocialAssistanceResource::make($this->socialAssistance),
            'head_of_family' => HeadOfFamilyResource::make($this->family),
            'amount' => $this->amount,
            'reason' => $this->reason,
            'bank' => $this->bank,
            'account_number' => $this->account_number,
            'proof' => $this->proof ? Storage::disk('public')->url($this->proof) : null,
            'status' => $this->status,
        ];
    }
}
