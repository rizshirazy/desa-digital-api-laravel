<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'thumbnail' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'is_active' => ['sometimes', 'boolean'],
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
            'name' => 'Nama acara',
            'thumbnail' => 'Gambar',
            'description' => 'Deskripsi',
            'price' => 'Harga',
            'date' => 'Tanggal',
            'time' => 'Waktu',
            'is_active' => 'Status aktif',
        ];
    }
}
