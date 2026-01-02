<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'about' => ['required', 'string'],
            'headman' => ['required', 'string', 'max:255'],
            'people' => ['required', 'integer', 'min:0'],
            'agricultural_area' => ['required', 'numeric', 'min:0'],
            'total_area' => ['required', 'numeric', 'min:0'],
            'images' => ['sometimes', 'array'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png', 'max:2048'],
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
            'name' => 'Nama profil',
            'thumbnail' => 'Gambar utama',
            'about' => 'Tentang',
            'headman' => 'Kepala desa',
            'people' => 'Jumlah penduduk',
            'agricultural_area' => 'Luas lahan pertanian',
            'total_area' => 'Luas wilayah',
            'images' => 'Galeri gambar',
            'images.*' => 'Gambar galeri',
        ];
    }
}
