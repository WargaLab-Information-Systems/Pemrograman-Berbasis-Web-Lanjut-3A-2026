<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan petugas dapat melihat semua peminjaman
        if ($user->hasRole(['admin', 'petugas'])) {
            return true;
        }

        // Siswa hanya dapat melihat peminjamannya sendiri
        return $user->anggota
            && $user->anggota->id === $peminjaman->anggota_id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Peminjaman $peminjaman): bool
    {
        return false;
    }

    public function delete(User $user, Peminjaman $peminjaman): bool
    {
        return false;
    }

    public function restore(User $user, Peminjaman $peminjaman): bool
    {
        return false;
    }

    public function forceDelete(User $user, Peminjaman $peminjaman): bool
    {
        return false;
    }
}