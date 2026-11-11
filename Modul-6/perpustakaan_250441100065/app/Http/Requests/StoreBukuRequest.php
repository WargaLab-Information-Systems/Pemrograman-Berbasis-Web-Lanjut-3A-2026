<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $wajib = $this->isMethod('post') ? 'required' : 'sometimes';

        return [
            'kategori_id'   => [$wajib, 'integer', 'exists:kategoris,id'],
            'judul'         => [$wajib, 'string', 'min:3', 'max:150'],
            'penulis'       => [$wajib, 'string', 'min:3', 'max:100'],
            'tahun_terbit'  => [$wajib, 'integer', 'between:1900,'.date('Y')],
        ];
    }

    public function messages(): array
    {
        return [
            'required'                => ':attribute wajib diisi.',
            'kategori_id.integer'     => 'Kategori harus berupa angka.',
            'kategori_id.exists'      => 'Kategori yang dipilih tidak valid.',
            'judul.string'            => 'Judul buku harus berupa teks.',
            'judul.min'               => 'Judul buku minimal 3 karakter.',
            'judul.max'               => 'Judul buku maksimal 150 karakter.',
            'penulis.string'          => 'Penulis harus berupa teks.',
            'penulis.min'             => 'Penulis minimal 3 karakter.',
            'penulis.max'             => 'Penulis maksimal 100 karakter.',
            'tahun_terbit.integer'    => 'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.between'    => 'Tahun terbit harus antara 1900 sampai '.date('Y').'.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}
