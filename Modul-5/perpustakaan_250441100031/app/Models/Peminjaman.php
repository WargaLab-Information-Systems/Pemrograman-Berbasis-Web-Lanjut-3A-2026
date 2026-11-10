<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara eksplisit sesuai dengan yang ada di database phpMyAdmin Anda
    protected $table = 'peminjamans'; // Ubah menjadi 'peminjamen' atau 'peminjaman' jika nama tabel di database berbeda

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}