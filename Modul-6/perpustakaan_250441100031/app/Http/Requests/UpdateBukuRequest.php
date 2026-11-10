<?php

namespace App\Http\Requests;

class UpdateBukuRequest extends StoreBukuRequest
{
    public function rules(): array
    {
        return [
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|not_regex:/^[0-9]+$/', // Memastikan penulis bukan angka
            'tahun_terbit' => 'required|digits:4',
        ];
    }
}
