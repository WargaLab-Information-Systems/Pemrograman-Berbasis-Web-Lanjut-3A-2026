<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan petugas boleh melihat semua peminjaman.
        if ($user->hasRole('admin') || $user->hasRole('petugas')) {
            return true;
        }

        // Siswa hanya boleh melihat peminjamannya sendiri.
        if ($user->hasRole('siswa')) {
            return $peminjaman->anggota?->user_id === $user->id;
        }

        return false;
    }
}
