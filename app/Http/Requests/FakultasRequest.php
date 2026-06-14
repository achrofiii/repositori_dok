<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FakultasRequest extends FormRequest
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
        $id = $this->route('fakulta');

        return [
            'nama_fakultas' => ['required', 'string', 'max:100', Rule::unique('fakultas')->ignore($id)],
            'kode_fakultas' => ['required', 'string', 'max:5', Rule::unique('fakultas')->ignore($id)],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_fakultas.required' => 'Nama fakultas harus diisi.',
            'nama_fakultas.string' => 'Nama fakultas harus berupa teks.',
            'nama_fakultas.max' => 'Nama fakultas maksimal 100 karakter.',
            'nama_fakultas.unique' => 'Nama fakultas sudah ada.',

            'kode_fakultas.required' => 'Kode fakultas harus diisi.',
            'kode_fakultas.string' => 'Kode fakultas harus berupa teks.',
            'kode_fakultas.max' => 'Kode fakultas maksimal 5 karakter.',
            'kode_fakultas.unique' => 'Kode fakultas sudah digunakan.',
        ];
    }
}
