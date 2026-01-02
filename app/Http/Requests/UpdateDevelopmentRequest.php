<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDevelopmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'description' => ['required', 'string'],
            'person_in_charge' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string', 'in:ongoing,completed'],
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
            'name' => 'Nama pembangunan',
            'thumbnail' => 'Gambar',
            'description' => 'Deskripsi',
            'person_in_charge' => 'Penanggung jawab',
            'start_date' => 'Tanggal mulai',
            'end_date' => 'Tanggal selesai',
            'amount' => 'Jumlah dana',
            'status' => 'Status',
        ];
    }
}
