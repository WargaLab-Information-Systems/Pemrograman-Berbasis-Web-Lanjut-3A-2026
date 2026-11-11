<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    public const DIAJUKAN = 'diajukan';
    public const DIPINJAM = 'dipinjam';
    public const DITOLAK = 'ditolak';
    public const DIKEMBALIKAN = 'dikembalikan';

    protected $table = 'peminjamans';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function scopeMilikUser(Builder $query, int $userId): Builder
    {
        return $query->whereHas('anggota', fn ($q) => $q->where('user_id', $userId));
    }
}
