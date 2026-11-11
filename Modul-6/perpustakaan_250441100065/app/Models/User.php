<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected static function booted(): void
    {
        static::updated(function (User $user) {
            if ($user->wasChanged(['name', 'email']) && $user->anggota) {
                $user->anggota->update(['nama' => $user->name, 'email' => $user->email]);
            }
        });
    }


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function anggota(): HasOne
    {
        return $this->hasOne(Anggota::class);
    }

    public function peminjamans(): HasManyThrough
    {
        return $this->hasManyThrough(Peminjaman::class, Anggota::class);
    }

    public function ensureAnggota(): Anggota
    {
        return $this->anggota ?? tap(
            $this->anggota()->create([
                'nama' => $this->name,
                'email' => $this->email,
                'no_telepon' => null,
            ]),
            fn ($anggota) => $this->setRelation('anggota', $anggota)
        );
    }
}
