<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    
    public function viewRiwayat(User $login, User $target): bool
    {
        return $login->id === $target->id || $login->can('kelola peminjaman');
    }
}
