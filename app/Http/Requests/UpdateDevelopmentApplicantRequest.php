<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDevelopmentApplicantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'development_id' => [
                'required',
                Rule::exists('developments', 'id')->whereNull('deleted_at'),
            ],
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->whereNull('deleted_at'),
            ],
            'status' => ['sometimes', 'string', 'in:approved,pending,rejected'],
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
            'development_id' => 'Pembangunan',
            'user_id' => 'User',
            'status' => 'Status',
        ];
    }
}
