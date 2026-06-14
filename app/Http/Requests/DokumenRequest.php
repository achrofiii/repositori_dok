<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DokumenRequest extends FormRequest
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
        $rules = [
            'judul' => 'required|string|max:255',
            'abstrak' => 'required|string',
            'kata_kunci' => 'required|string',
            'tahun_publikasi' => 'required|digits:4|integer|min:1900|max:2099',
            'kategori' => 'required|exists:kategoris,id',
            'fakultas' => 'required|exists:fakultas,id',
            'jurusan' => 'required|exists:jurusans,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($this->isMethod('post')) {
            $rules['file_dokumen'] = 'required|file|mimes:pdf,doc,docx|max:10240';
        } else {
            $rules['file_dokumen'] = 'nullable|file|mimes:pdf,doc,docx|max:10240';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul dokumen wajib diisi.',
            'judul.max' => 'Judul dokumen maksimal 255 karakter.',
            'abstrak.required' => 'Abstrak dokumen wajib diisi.',
            'kata_kunci.required' => 'Kata kunci wajib diisi.',
            'tahun_publikasi.required' => 'Tahun publikasi wajib diisi.',
            'tahun_publikasi.digits' => 'Tahun publikasi harus terdiri dari 4 digit.',
            'tahun_publikasi.integer' => 'Tahun publikasi harus berupa angka.',
            'tahun_publikasi.min' => 'Tahun publikasi minimal 1900.',
            'tahun_publikasi.max' => 'Tahun publikasi maksimal 2099.',
            'kategori.required' => 'Kategori dokumen wajib dipilih.',
            'kategori.exists' => 'Kategori tidak ditemukan.',
            'fakultas.required' => 'Fakultas wajib dipilih.',
            'fakultas.exists' => 'Fakultas tidak ditemukan.',
            'jurusan.required' => 'Jurusan wajib dipilih.',
            'jurusan.exists' => 'Jurusan tidak ditemukan.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Thumbnail harus berformat: jpeg, png, atau jpg.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'file_dokumen.required' => 'File dokumen wajib diunggah.',
            'file_dokumen.file' => 'File dokumen tidak valid.',
            'file_dokumen.mimes' => 'File dokumen harus berformat: pdf, doc, atau docx.',
            'file_dokumen.max' => 'Ukuran file dokumen maksimal 10MB.',
        ];
    }
}
