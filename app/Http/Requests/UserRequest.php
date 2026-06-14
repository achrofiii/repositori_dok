<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $csId = $this->route('custommer_service');

        return [
            'name' => 'required|string|max:50',
            'nip_nim' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($csId),
            ],
            'username' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('users')->ignore($csId)
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($csId)
            ],
            'password' => 'nullable|string|min:6',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 50 karakter',
            'nip_nim.required' => 'NIP/NIM wajib diisi',
            'nip_nim.max' => 'NIP/NIM maksimal 20 karakter',
            'nip_nim.unique' => 'NIP/NIM sudah ada.',
            'username.required' => 'Username wajib diisi',
            'username.max' => 'Username maksimal 50 karakter',
            'username.unique' => 'Username sudah ada.',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah ada.',
            'password.min' => 'Password minimal 6 karakter',
        ];
    }
}
