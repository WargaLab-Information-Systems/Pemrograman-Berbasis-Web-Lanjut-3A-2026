<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    /**
     * [SOAL 4] Siapa yang boleh melihat sebuah peminjaman?
     * - admin & petugas : semua peminjaman
     * - siswa           : hanya peminjaman miliknya sendiri
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        return $peminjaman->anggota?->user_id === $user->id;
    }
}
