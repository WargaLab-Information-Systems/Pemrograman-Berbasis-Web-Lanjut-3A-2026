<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        // Data acak bawaan modul sebelumnya
        Peminjaman::factory(3)->create();

        // Data contoh untuk dua akun siswa supaya riwayat tidak kosong
        $buku = Buku::pluck('id')->values();
        if ($buku->count() < 4) {
            return;
        }

        $siswa1 = User::where('email', 'siswa@gmail.com')->first()?->ensureAnggota();
        $siswa2 = User::where('email', 'siswa2@gmail.com')->first()?->ensureAnggota();

        if ($siswa1) {
            Peminjaman::create(['anggota_id' => $siswa1->id, 'buku_id' => $buku[0], 'tanggal_pinjam' => now()->subDays(20), 'tanggal_kembali' => now()->subDays(10), 'status' => Peminjaman::DIKEMBALIKAN]);
            Peminjaman::create(['anggota_id' => $siswa1->id, 'buku_id' => $buku[1], 'tanggal_pinjam' => now()->subDays(3),  'tanggal_kembali' => null, 'status' => Peminjaman::DIPINJAM]);
            Peminjaman::create(['anggota_id' => $siswa1->id, 'buku_id' => $buku[2], 'tanggal_pinjam' => null, 'tanggal_kembali' => null, 'status' => Peminjaman::DIAJUKAN]);
        }

        if ($siswa2) {
            Peminjaman::create(['anggota_id' => $siswa2->id, 'buku_id' => $buku[3], 'tanggal_pinjam' => now()->subDays(15), 'tanggal_kembali' => now()->subDays(5), 'status' => Peminjaman::DIKEMBALIKAN]);
            Peminjaman::create(['anggota_id' => $siswa2->id, 'buku_id' => $buku[0], 'tanggal_pinjam' => null, 'tanggal_kembali' => null, 'status' => Peminjaman::DIAJUKAN]);
        }
    }
}
