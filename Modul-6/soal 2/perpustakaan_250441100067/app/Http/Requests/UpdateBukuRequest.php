<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id' => [
                'sometimes',
                'required',
                'exists:kategoris,id',
            ],

            'judul' => [
                'sometimes',
                'required',
                'string',
                'min:3',
            ],

            'penulis' => [
                'sometimes',
                'required',
                'string',
            ],

            'tahun_terbit' => [
                'sometimes',
                'required',
                'integer',
                'between:1900,2026',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_id.required' => 'Kategori wajib diisi.',
            'kategori_id.exists' => 'Kategori tidak ditemukan.',

            'judul.required' => 'Judul wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.min' => 'Judul minimal 3 karakter.',

            'penulis.required' => 'Penulis wajib diisi.',
            'penulis.string' => 'Penulis harus berupa teks.',

            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.between' => 'Tahun terbit harus antara 1900 dan 2026.',
        ];
    }
}