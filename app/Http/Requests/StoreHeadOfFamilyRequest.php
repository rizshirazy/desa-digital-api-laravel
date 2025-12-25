<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreHeadOfFamilyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // User data (required on create)
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', Password::defaults()],
            // Head of family data
            'profile_picture' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'identity_number' => ['required', 'digits:16', Rule::unique('head_of_families', 'identity_number')],
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
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Kata sandi',
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
