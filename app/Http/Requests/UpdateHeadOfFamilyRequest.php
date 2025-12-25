<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHeadOfFamilyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $headOfFamily = $this->route('head_of_family');
        $headOfFamilyId = is_object($headOfFamily) ? $headOfFamily->id : $headOfFamily;

        return [
            // User fields are not updatable here
            'name' => ['prohibited'],
            'email' => ['prohibited'],
            'password' => ['prohibited'],
            // Head of family data
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'identity_number' => [
                'required',
                'digits:16',
                Rule::unique('head_of_families', 'identity_number')->ignore($headOfFamilyId),
            ],
            'gender' => ['required', 'string', 'in:male,female'],
            'date_of_birth' => ['required', 'date'],
            'phone_number' => ['required', 'string', 'max:20'],
            'occupation' => ['required', 'string', 'max:255'],
            'marital_status' => ['required', 'string', 'in:married,single,divorced'],
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
            'profile_picture' => 'Foto profil',
            'identity_number' => 'Nomor identitas',
            'gender' => 'Jenis kelamin',
            'date_of_birth' => 'Tanggal lahir',
            'phone_number' => 'Nomor telepon',
            'occupation' => 'Pekerjaan',
            'marital_status' => 'Status pernikahan',
        ];
    }
}
