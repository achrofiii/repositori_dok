<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JurusanRequest extends FormRequest
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
        $id = $this->route('jurusan');

        return [
            'nama_jurusan' => ['required', 'string', 'max:100', Rule::unique('jurusans')->ignore($id)],
            'kode_jurusan' => ['required', 'string', 'max:10', Rule::unique('jurusans')->ignore($id)],
            'fakultas_id' => 'required|exists:fakultas,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_jurusan.required' => 'Nama jurusan harus diisi.',
            'nama_jurusan.string' => 'Nama jurusan harus berupa teks.',
            'nama_jurusan.max' => 'Nama jurusan maksimal 100 karakter.',
            'nama_jurusan.unique' => 'Nama jurusan sudah ada.',

            'kode_jurusan.required' => 'Kode jurusan harus diisi.',
            'kode_jurusan.string' => 'Kode jurusan harus berupa teks.',
            'kode_jurusan.max' => 'Kode jurusan maksimal 10 karakter.',
            'kode_jurusan.unique' => 'Kode jurusan sudah digunakan.',

            'fakultas_id.required' => 'Fakultas harus dipilih.',
            'fakultas_id.exists' => 'Fakultas yang dipilih tidak valid.',

            'deskripsi.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
