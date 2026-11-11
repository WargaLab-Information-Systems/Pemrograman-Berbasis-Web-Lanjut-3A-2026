<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class RbacTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $petugas;
    private User $siswa;
    private User $siswaLain;
    private Buku $buku;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->admin = $this->buatUser('admin');
        $this->petugas = $this->buatUser('petugas');
        $this->siswa = $this->buatUser('siswa');
        $this->siswaLain = $this->buatUser('siswa');

        $kategori = Kategori::create(['nama' => 'Pemrograman']);
        $this->buku = Buku::create([
            'kategori_id' => $kategori->id,
            'judul' => 'Belajar Laravel',
            'penulis' => 'Penulis Satu',
            'tahun_terbit' => 2024,
        ]);
    }

    private function buatUser(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);
        $user->ensureAnggota();

        return $user;
    }

    /* ---------------------- Skenario 1 ---------------------- */
    public function test_01_belum_login_dashboard_admin_dialihkan_ke_login(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    /* ---------------------- Skenario 2-5 : Admin ---------------------- */
    public function test_02_admin_bisa_buka_dashboard_admin(): void
    {
        $this->actingAs($this->admin)->get('/admin/dashboard')->assertOk();
    }

    public function test_03_admin_bisa_tambah_ubah_hapus_buku(): void
    {
        $payload = ['kategori_id' => $this->buku->kategori_id, 'judul' => 'Buku Baru', 'penulis' => 'Penulis Dua', 'tahun_terbit' => 2023];

        $res = $this->actingAs($this->admin)->postJson('/api/buku', $payload)->assertCreated();
        $id = $res->json('data.id');

        $this->actingAs($this->admin)->putJson("/api/buku/$id", array_merge($payload, ['judul' => 'Buku Diubah']))->assertOk();
        $this->assertDatabaseHas('bukus', ['id' => $id, 'judul' => 'Buku Diubah']);

        $this->actingAs($this->admin)->deleteJson("/api/buku/$id")->assertOk();
        $this->assertDatabaseMissing('bukus', ['id' => $id]);
    }

    public function test_04_admin_bisa_kelola_akun_dan_role_pengguna(): void
    {
        $this->actingAs($this->admin)->get('/admin/users')->assertOk();

        $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Petugas Baru', 'email' => 'baru@example.com', 'role' => 'petugas',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertRedirect('/admin/users');

        $baru = User::where('email', 'baru@example.com')->firstOrFail();
        $this->assertTrue($baru->hasRole('petugas'));

        $this->actingAs($this->admin)->patch("/admin/users/{$baru->id}/role", ['role' => 'siswa'])->assertRedirect();
        $this->assertTrue($baru->fresh()->hasRole('siswa'));
        $this->assertFalse($baru->fresh()->hasRole('petugas'));
    }

    public function test_05_admin_bisa_akses_peminjaman_pengembalian_dan_laporan(): void
    {
        $this->actingAs($this->admin)->get('/kelola/peminjaman')->assertOk();
        $this->actingAs($this->admin)->get('/kelola/pengembalian')->assertOk();
        $this->actingAs($this->admin)->get('/laporan')->assertOk();
    }

    /* ---------------------- Skenario 6-9 : Petugas ---------------------- */
    public function test_06_petugas_bisa_buka_dashboard_petugas(): void
    {
        $this->actingAs($this->petugas)->get('/petugas/dashboard')->assertOk();
    }

    public function test_07_petugas_bisa_kelola_data_buku(): void
    {
        $this->actingAs($this->petugas)->get('/kelola/buku')->assertOk();

        $payload = ['kategori_id' => $this->buku->kategori_id, 'judul' => 'Buku Petugas', 'penulis' => 'Penulis Tiga', 'tahun_terbit' => 2022];
        $this->actingAs($this->petugas)->postJson('/api/buku', $payload)->assertCreated();
    }

    public function test_08_petugas_bisa_proses_peminjaman_dan_pengembalian(): void
    {
        // siswa mengajukan
        $this->actingAs($this->siswa)->post("/buku/{$this->buku->id}/pinjam")->assertRedirect();
        $pinjam = Peminjaman::firstOrFail();
        $this->assertSame('diajukan', $pinjam->status);

        // petugas menyetujui
        $this->actingAs($this->petugas)->post("/kelola/peminjaman/{$pinjam->id}/setujui")->assertRedirect();
        $this->assertSame('dipinjam', $pinjam->fresh()->status);

        // petugas mencatat pengembalian
        $this->actingAs($this->petugas)->post("/kelola/pengembalian/{$pinjam->id}")->assertRedirect();
        $this->assertSame('dikembalikan', $pinjam->fresh()->status);
        $this->assertNotNull($pinjam->fresh()->tanggal_kembali);
    }

    public function test_09_petugas_ditolak_di_halaman_pengelolaan_akun_dan_role(): void
    {
        $this->actingAs($this->petugas)->get('/admin/users')->assertForbidden();
        $this->actingAs($this->petugas)->get('/admin/users/create')->assertForbidden();
        $this->actingAs($this->petugas)->patch("/admin/users/{$this->siswa->id}/role", ['role' => 'admin'])->assertForbidden();
        $this->assertTrue($this->siswa->fresh()->hasRole('siswa'));
        // dan petugas tidak boleh membuka dashboard admin
        $this->actingAs($this->petugas)->get('/admin/dashboard')->assertForbidden();
    }

    /* ---------------------- Skenario 10-14 : Siswa ---------------------- */
    public function test_10_siswa_bisa_lihat_daftar_dan_detail_buku(): void
    {
        $this->actingAs($this->siswa)->get('/buku')->assertOk()->assertSee('Belajar Laravel');
        $this->actingAs($this->siswa)->get("/buku/{$this->buku->id}")->assertOk()->assertSee('Belajar Laravel');
    }

    public function test_11_siswa_bisa_lihat_dan_ubah_profil_sendiri(): void
    {
        $this->actingAs($this->siswa)->get('/profile')->assertOk();

        $this->actingAs($this->siswa)->patch('/profile', [
            'name' => 'Nama Baru Siswa',
            'email' => $this->siswa->email,
        ])->assertRedirect('/profile');

        $this->assertSame('Nama Baru Siswa', $this->siswa->fresh()->name);
        // nama di data anggota ikut tersinkron
        $this->assertSame('Nama Baru Siswa', $this->siswa->fresh()->anggota->nama);
    }

    public function test_12_siswa_bisa_lihat_riwayat_peminjaman_sendiri(): void
    {
        Peminjaman::create([
            'anggota_id' => $this->siswa->anggota->id, 'buku_id' => $this->buku->id,
            'tanggal_pinjam' => now()->subDays(5), 'tanggal_kembali' => now()->subDay(), 'status' => 'dikembalikan',
        ]);

        $this->actingAs($this->siswa)->get('/riwayat-peminjaman')->assertRedirect("/riwayat-peminjaman/{$this->siswa->id}");
        $this->actingAs($this->siswa)->get("/riwayat-peminjaman/{$this->siswa->id}")->assertOk()->assertSee('Belajar Laravel');
        $this->actingAs($this->siswa)->get('/peminjaman-saya')->assertOk();
    }

    public function test_13_siswa_ditolak_di_dashboard_admin_dan_pengelolaan_buku(): void
    {
        $this->actingAs($this->siswa)->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($this->siswa)->get('/petugas/dashboard')->assertForbidden();
        $this->actingAs($this->siswa)->get('/kelola/buku')->assertForbidden();
        $this->actingAs($this->siswa)->get('/laporan')->assertForbidden();
        $this->actingAs($this->siswa)->get('/kelola/peminjaman')->assertForbidden();
        $this->actingAs($this->siswa)->get('/admin/users')->assertForbidden();

        // akses langsung lewat API juga ditolak
        $payload = ['kategori_id' => $this->buku->kategori_id, 'judul' => 'Buku Nakal', 'penulis' => 'Penyusup', 'tahun_terbit' => 2020];
        $this->actingAs($this->siswa)->postJson('/api/buku', $payload)->assertForbidden();
        $this->actingAs($this->siswa)->deleteJson("/api/buku/{$this->buku->id}")->assertForbidden();
        $this->assertDatabaseHas('bukus', ['id' => $this->buku->id]);
    }

    public function test_14_siswa_tidak_bisa_lihat_riwayat_siswa_lain(): void
    {
        $this->actingAs($this->siswa)->get("/riwayat-peminjaman/{$this->siswaLain->id}")->assertForbidden();
        // staf boleh melihat
        $this->actingAs($this->petugas)->get("/riwayat-peminjaman/{$this->siswaLain->id}")->assertOk();
    }

    /* ---------------------- Skenario 15 : logout ---------------------- */
    public function test_15_setelah_logout_harus_login_lagi(): void
    {
        foreach ([$this->admin, $this->petugas, $this->siswa] as $user) {
            $this->actingAs($user)->post('/logout')->assertRedirect('/');
            $this->assertGuest();

            $this->get('/dashboard')->assertRedirect('/login');
            $this->get('/buku')->assertRedirect('/login');
        }
    }

    /* ---------------------- Uji keamanan tambahan ---------------------- */
    public function test_registrasi_selalu_menjadi_siswa_walau_mengirim_role_admin(): void
    {
        $this->post('/register', [
            'name' => 'Penyusup', 'email' => 'penyusup@example.com',
            'password' => 'password123', 'password_confirmation' => 'password123',
            'role' => 'admin',
        ])->assertRedirect('/dashboard');

        $user = User::where('email', 'penyusup@example.com')->firstOrFail();
        $this->assertTrue($user->hasRole('siswa'));
        $this->assertFalse($user->hasRole('admin'));
        $this->assertNotNull($user->anggota);
        $this->assertNotSame('password123', $user->password); // tersimpan sebagai hash
    }

    public function test_login_gagal_dengan_kredensial_salah(): void
    {
        $this->post('/login', ['email' => $this->siswa->email, 'password' => 'salah-total'])->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_sudah_login_tidak_bisa_buka_halaman_login_dan_register(): void
    {
        $this->actingAs($this->siswa)->get('/login')->assertRedirect('/dashboard');
        $this->actingAs($this->siswa)->get('/register')->assertRedirect('/dashboard');
    }

    public function test_dashboard_diarahkan_sesuai_role(): void
    {
        $this->actingAs($this->admin)->get('/dashboard')->assertRedirect('/admin/dashboard');
        $this->actingAs($this->petugas)->get('/dashboard')->assertRedirect('/petugas/dashboard');
        $this->actingAs($this->siswa)->get('/dashboard')->assertOk();
    }

    public function test_api_buku_tanpa_login_ditolak(): void
    {
        $this->getJson('/api/buku')->assertUnauthorized();
        $this->postJson('/api/buku', [])->assertUnauthorized();
    }

    public function test_admin_tidak_bisa_mengubah_role_atau_menghapus_akun_sendiri(): void
    {
        $this->actingAs($this->admin)->patch("/admin/users/{$this->admin->id}/role", ['role' => 'siswa'])->assertSessionHas('error');
        $this->assertTrue($this->admin->fresh()->hasRole('admin'));

        $this->actingAs($this->admin)->delete("/admin/users/{$this->admin->id}")->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_pengajuan_ganda_untuk_buku_yang_sama_ditolak(): void
    {
        $this->actingAs($this->siswa)->post("/buku/{$this->buku->id}/pinjam");
        $this->actingAs($this->siswa)->post("/buku/{$this->buku->id}/pinjam")->assertSessionHas('error');
        $this->assertSame(1, Peminjaman::count());
    }

    public function test_siswa_tidak_bisa_menyetujui_peminjaman(): void
    {
        $this->actingAs($this->siswa)->post("/buku/{$this->buku->id}/pinjam");
        $pinjam = Peminjaman::firstOrFail();

        $this->actingAs($this->siswa)->post("/kelola/peminjaman/{$pinjam->id}/setujui")->assertForbidden();
        $this->assertSame('diajukan', $pinjam->fresh()->status);
    }

    public function test_jumlah_permission_dan_pembagian_role_sesuai_tabel(): void
    {
        $this->assertSame(16, \Spatie\Permission\Models\Permission::count());
        $this->assertSame(3, \Spatie\Permission\Models\Role::count());

        $this->assertTrue($this->admin->can('akses dashboard admin'));
        $this->assertFalse($this->admin->can('akses dashboard petugas'));
        $this->assertTrue($this->petugas->can('akses dashboard petugas'));
        $this->assertFalse($this->petugas->can('kelola data pengguna'));
        $this->assertFalse($this->petugas->can('kelola role pengguna'));
        $this->assertTrue($this->siswa->can('lihat daftar buku'));
        $this->assertFalse($this->siswa->can('kelola data buku'));
        $this->assertFalse($this->siswa->can('lihat laporan perpustakaan'));
    }
}
