<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateFamilyMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $familyMember = $this->route('family_member');
        $familyMemberId = is_object($familyMember) ? $familyMember->id : $familyMember;
        $userId = is_object($familyMember) ? $familyMember->user_id : null;

        return [
            'head_of_family_id' => ['required', 'exists:head_of_families,id'],
            // User data
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', Password::defaults()],
            // Family member data
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'identity_number' => ['required', 'digits:16', Rule::unique('family_members', 'identity_number')->ignore($familyMemberId)],
            'gender' => ['required', 'string', 'in:male,female'],
            'date_of_birth' => ['required', 'date'],
            'phone_number' => ['required', 'string', 'max:20'],
            'occupation' => ['required', 'string', 'max:255'],
            'marital_status' => ['required', 'string', 'in:single,married'],
            'relation' => ['required', 'string', 'in:wife,husband,child'],
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
            'head_of_family_id' => 'Kepala keluarga',
            'profile_picture' => 'Foto profil',
            'identity_number' => 'Nomor identitas',
            'gender' => 'Jenis kelamin',
            'date_of_birth' => 'Tanggal lahir',
            'phone_number' => 'Nomor telepon',
            'occupation' => 'Pekerjaan',
            'marital_status' => 'Status pernikahan',
            'relation' => 'Hubungan keluarga',
        ];
    }
}
