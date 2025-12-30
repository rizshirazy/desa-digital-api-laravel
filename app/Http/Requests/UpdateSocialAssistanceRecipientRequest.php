<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialAssistanceRecipientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'social_assistance_id' => ['required', 'exists:social_assistances,id'],
            'head_of_family_id' => ['required', 'exists:head_of_families,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'reason' => ['required', 'string'],
            'bank' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'numeric'],
            'proof' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
            'status' => ['sometimes', 'string', 'in:pending,approved,rejected'],
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
            'social_assistance_id' => 'Bantuan sosial',
            'head_of_family_id' => 'Kepala keluarga',
            'amount' => 'Jumlah',
            'reason' => 'Alasan',
            'bank' => 'Bank',
            'account_number' => 'Nomor rekening',
            'proof' => 'Bukti',
            'status' => 'Status',
        ];
    }
}
