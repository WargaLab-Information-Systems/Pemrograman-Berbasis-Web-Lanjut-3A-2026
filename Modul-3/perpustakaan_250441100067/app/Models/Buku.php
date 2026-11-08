<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'kategori_id',
        'judul',
        'penulis',
        'tahun_terbit',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}
