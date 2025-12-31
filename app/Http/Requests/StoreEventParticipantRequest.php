<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventParticipantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => ['required', 'exists:events,id'],
            'head_of_family_id' => ['required', 'exists:head_of_families,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Custom attribute names.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'event_id' => 'Acara',
            'head_of_family_id' => 'Kepala keluarga',
            'quantity' => 'Jumlah tiket',
        ];
    }
}
