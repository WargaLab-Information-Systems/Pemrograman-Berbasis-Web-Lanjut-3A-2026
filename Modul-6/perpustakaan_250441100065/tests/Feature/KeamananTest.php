<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Pengujian Modul 6: memastikan celah A1-A4 sudah tertutup.
 * Jalankan: php artisan test --filter=KeamananTest
 */
class KeamananTest extends TestCase
{
    use RefreshDatabase;

    private const PAYLOAD = "<script>alert('250441100065')</script>";

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

        $kategori = Kategori::create(['nama' => 'Keamanan']);
        $this->buku = Buku::create([
            'kategori_id' => $kategori->id,
            'judul' => self::PAYLOAD,
            'penulis' => 'Penulis Uji',
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

    /* ---------- A1 : XSS ---------- */
    public function test_a1_judul_buku_di_daftar_buku_di_escape(): void
    {
        $this->actingAs($this->siswa)->get('/buku')
            ->assertOk()
            ->assertDontSee(self::PAYLOAD, false)           // tag <script> mentah tidak boleh muncul
            ->assertSee('&lt;script&gt;', false);           // tampil sebagai teks
    }

    /* ---------- A2 : SQL Injection ---------- */
    public function test_a2_payload_sql_injection_menghasilkan_array_kosong(): void
    {
        $this->actingAs($this->admin)->getJson("/buku-cari?judul=' OR '1'='1")
            ->assertOk()->assertExactJson([]);
    }

    public function test_a2_pencarian_normal_tetap_berfungsi(): void
    {
        $res = $this->actingAs($this->admin)->getJson('/buku-cari?judul='.urlencode(self::PAYLOAD))->assertOk();
        $this->assertCount(1, $res->json());
    }

    public function test_a2_harus_login(): void
    {
        $this->get('/buku-cari?judul=x')->assertRedirect('/login');
    }

    /* ---------- A3 : CSRF / hapus via GET ---------- */
    public function test_a3_route_get_hapus_sudah_tidak_ada(): void
    {
        $this->actingAs($this->admin)->get("/buku/{$this->buku->id}/hapus")->assertNotFound();
        $this->assertDatabaseHas('bukus', ['id' => $this->buku->id]);
    }

    public function test_a3_hapus_lewat_delete_berhasil_untuk_admin(): void
    {
        $this->actingAs($this->admin)->delete("/buku/{$this->buku->id}")->assertRedirect('/buku');
        $this->assertDatabaseMissing('bukus', ['id' => $this->buku->id]);
    }

    public function test_a3_form_hapus_memuat_csrf_dan_method_delete(): void
    {
        $html = $this->actingAs($this->admin)->get('/buku')->getContent();

        $this->assertStringContainsString('name="_token"', $html);
        $this->assertStringContainsString('name="_method" value="DELETE"', $html);
    }

    /* ---------- Gate kelola-buku (Soal 3) ---------- */
    public function test_siswa_ditolak_di_form_dan_aksi_kelola_buku(): void
    {
        $this->actingAs($this->siswa)->get('/buku/create')->assertForbidden();
        $this->actingAs($this->siswa)->get("/buku/{$this->buku->id}/edit")->assertForbidden();
        $this->actingAs($this->siswa)->delete("/buku/{$this->buku->id}")->assertForbidden();
        $this->actingAs($this->siswa)->post('/buku', [])->assertForbidden();
        $this->assertDatabaseHas('bukus', ['id' => $this->buku->id]);
    }

    public function test_admin_dan_petugas_bisa_membuka_form_tambah_dan_ubah(): void
    {
        foreach ([$this->admin, $this->petugas] as $user) {
            $this->actingAs($user)->get('/buku/create')->assertOk();
            $this->actingAs($user)->get("/buku/{$this->buku->id}/edit")->assertOk();
        }
    }

    public function test_admin_dan_petugas_bisa_tambah_dan_ubah_buku(): void
    {
        $data = ['kategori_id' => $this->buku->kategori_id, 'judul' => 'Buku Baru', 'penulis' => 'Penulis Baru', 'tahun_terbit' => 2023];

        $this->actingAs($this->petugas)->post('/buku', $data)->assertRedirect('/buku');
        $baru = Buku::where('judul', 'Buku Baru')->firstOrFail();

        $this->actingAs($this->admin)->put("/buku/{$baru->id}", array_merge($data, ['judul' => 'Judul Diubah']))->assertRedirect('/buku');
        $this->assertSame('Judul Diubah', $baru->fresh()->judul);
    }

    public function test_tombol_kelola_hanya_tampil_untuk_admin_dan_petugas(): void
    {
        $this->actingAs($this->siswa)->get('/buku')
            ->assertDontSee('Tambah Buku')->assertDontSee('>Hapus<', false)->assertDontSee('>Ubah<', false);

        foreach ([$this->admin, $this->petugas] as $user) {
            $this->actingAs($user)->get('/buku')
                ->assertSee('Tambah Buku')->assertSee('>Hapus<', false)->assertSee('>Ubah<', false);
        }
    }

    public function test_api_tambah_ubah_hapus_buku_dijaga_gate(): void
    {
        $data = ['kategori_id' => $this->buku->kategori_id, 'judul' => 'Lewat API', 'penulis' => 'Penulis API', 'tahun_terbit' => 2022];

        $this->actingAs($this->siswa)->postJson('/api/buku', $data)->assertForbidden();
        $this->actingAs($this->siswa)->deleteJson("/api/buku/{$this->buku->id}")->assertForbidden();
        $this->actingAs($this->petugas)->postJson('/api/buku', $data)->assertCreated();
    }

    /* ---------- A4 : IDOR (Policy) ---------- */
    public function test_a4_siswa_pemilik_dapat_200(): void
    {
        $p = $this->buatPeminjaman($this->siswa);
        $this->actingAs($this->siswa)->get("/peminjaman/{$p->id}")->assertOk();
    }

    public function test_a4_siswa_lain_dapat_403(): void
    {
        $p = $this->buatPeminjaman($this->siswa);
        $this->actingAs($this->siswaLain)->get("/peminjaman/{$p->id}")->assertForbidden();
    }

    public function test_a4_admin_dan_petugas_dapat_200(): void
    {
        $p = $this->buatPeminjaman($this->siswa);
        $this->actingAs($this->admin)->get("/peminjaman/{$p->id}")->assertOk();
        $this->actingAs($this->petugas)->get("/peminjaman/{$p->id}")->assertOk();
    }

    public function test_a4_belum_login_dialihkan_ke_login(): void
    {
        $p = $this->buatPeminjaman($this->siswa);
        $this->get("/peminjaman/{$p->id}")->assertRedirect('/login');
    }

    private function buatPeminjaman(User $pemilik): Peminjaman
    {
        return Peminjaman::create([
            'anggota_id' => $pemilik->anggota->id,
            'buku_id' => $this->buku->id,
            'status' => Peminjaman::DIAJUKAN,
        ]);
    }

    /* ---------- Soal 5 : konfigurasi ---------- */
    public function test_password_bawaan_admin_tidak_lagi_berlaku(): void
    {
        $this->seed(UserSeeder::class);

        $admin = User::where('email', 'admin@gmail.com')->firstOrFail();

        $this->assertFalse(Hash::check('password', $admin->password));
        $this->post('/login', ['email' => 'admin@gmail.com', 'password' => 'password'])->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_env_example_memakai_debug_false(): void
    {
        $this->assertStringContainsString('APP_DEBUG=false', file_get_contents(base_path('.env.example')));
    }

    public function test_htaccess_memblokir_berkas_tersembunyi(): void
    {
        $this->assertStringContainsString('FilesMatch', file_get_contents(public_path('.htaccess')));
    }
}
