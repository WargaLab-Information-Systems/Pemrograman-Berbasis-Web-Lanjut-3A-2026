@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

<style>
    body {
        background-color: #dcdafa !important;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    body > div,
    .min-h-screen,
    main {
        background-color: #dcdafa !important;
    }

    .halaman-buku {
        background-color: #dcdafa !important;
        min-height: 100vh;
        padding: 20px 13px;
        box-sizing: border-box;
    }

    .judul-halaman {
        color: #754b32;
        margin: 0 0 18px;
        font-size: 22px;
        font-weight: bold;
    }

    .form-buku {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 22px;
    }

    .form-buku h3 {
        color: #754b32;
        margin-top: 0;
        font-size: 16px;
        font-weight: bold;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .field-buku label {
        display: block;
        font-size: 13px;
        margin-bottom: 6px;
        color: #333;
    }

    .field-buku input,
    .field-buku select {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #d4c9c1;
        border-radius: 6px;
        font-size: 13px;
        background: white;
    }

    .field-buku input:focus,
    .field-buku select:focus {
        outline: none;
        border-color: #91613f;
    }

    .aksi-form,
    .aksi-kartu {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 14px;
    }

    .tombol {
        display: inline-block;
        border: none;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
        color: white;
    }

    .tombol:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .tombol-detail,
    .tombol-simpan {
        background-color: #91613f;
    }

    .tombol-detail:hover,
    .tombol-simpan:hover {
        background-color: #70472e;
        color: white;
    }

    .tombol-ubah {
        background-color: #6b67a8;
    }

    .tombol-ubah:hover {
        background-color: #514d91;
    }

    .tombol-hapus {
        background-color: #b84d4d;
    }

    .tombol-hapus:hover {
        background-color: #963838;
    }

    .tombol-batal {
        background-color: #777;
    }

    .daftar-buku {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        padding: 0;
    }

    .kartu-buku {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 18px;
        min-height: 153px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        box-sizing: border-box;
        transition: 0.2s;
    }

    .kartu-buku:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
    }

    .kartu-buku h3 {
        color: #754b32;
        font-size: 14px;
        margin: 0 0 10px;
        font-weight: bold;
        overflow-wrap: anywhere;
    }

    .kartu-buku p {
        font-size: 12px;
        color: #222;
        margin: 0 0 5px;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .kategori-buku {
        display: table;
        background-color: #efdbc3;
        color: #76553b;
        padding: 3px 9px;
        border-radius: 12px;
        font-size: 10px;
        margin-top: 10px;
    }

    .pesan {
        display: none;
        padding: 12px;
        border-radius: 7px;
        margin-bottom: 15px;
        font-size: 13px;
        white-space: pre-line;
    }

    .pesan.sukses {
        display: block;
        background: #e1f4e5;
        color: #226534;
    }

    .pesan.gagal {
        display: block;
        background: #fde5e5;
        color: #9a2525;
    }

    .pesan-kosong {
        color: #333;
        padding: 15px;
    }

    @media (max-width: 900px) {
        .daftar-buku {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 500px) {
        .daftar-buku,
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="halaman-buku">

    <h2 class="judul-halaman">Daftar Buku</h2>

    @if (session('success'))
        <div class="pesan sukses">
            {{ session('success') }}
        </div>
    @endif

    <div id="pesan" class="pesan"
        role="status" aria-live="polite"></div>

    {{-- FORM TAMBAH DAN UBAH BUKU --}}
    @can('kelola-buku')

        <div class="form-buku">

            <h3 id="judul-form">Tambah Buku</h3>

            <form id="form-buku">

                <input type="hidden" id="buku-id">

                <div class="form-grid">

                    <div class="field-buku">
                        <label for="kategori_id">Kategori</label>

                        <select id="kategori_id"
                            name="kategori_id" required>

                            <option value="">-- Pilih Kategori --</option>

                            {{-- KATEGORI TANPA NAMA DUPLIKAT --}}
                            @foreach ($kategori->unique('nama') as $kat)
                                <option value="{{ $kat->id }}">
                                    {{ $kat->nama }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="field-buku">
                        <label for="judul">Judul Buku</label>

                        <input type="text"
                            id="judul"
                            name="judul"
                            minlength="3"
                            maxlength="150"
                            required>
                    </div>

                    <div class="field-buku">
                        <label for="penulis">Penulis</label>

                        <input type="text"
                            id="penulis"
                            name="penulis"
                            minlength="3"
                            maxlength="100"
                            required>
                    </div>

                    <div class="field-buku">
                        <label for="tahun_terbit">Tahun Terbit</label>

                        <input type="number"
                            id="tahun_terbit"
                            name="tahun_terbit"
                            min="1900"
                            max="{{ date('Y') }}"
                            required>
                    </div>

                </div>

                <div class="aksi-form">

                    <button type="submit"
                        id="tombol-simpan"
                        class="tombol tombol-simpan">
                        Tambah Buku
                    </button>

                    <button type="button"
                        id="tombol-batal"
                        class="tombol tombol-batal"
                        hidden>
                        Batal Ubah
                    </button>

                </div>

            </form>

        </div>

    @endcan

    {{-- DAFTAR KARTU BUKU --}}
    <div id="daftar-buku" class="daftar-buku">

        @forelse ($buku as $item)

            <div class="kartu-buku">

                <h3>{{ $item->judul }}</h3>

                <p>Penulis: {{ $item->penulis }}</p>

                <p>Tahun Terbit: {{ $item->tahun_terbit }}</p>

                <span class="kategori-buku">
                    {{ $item->kategori->nama ?? 'Tanpa Kategori' }}
                </span>

                <a href="{{ route('buku.show', $item->id) }}"
                    class="tombol tombol-detail">
                    Lihat Detail
                </a>

            </div>

        @empty

            <p class="pesan-kosong">Belum ada data buku.</p>

        @endforelse

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const API_URL = '/api/buku';

    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    )?.getAttribute('content');

    const form = document.getElementById('form-buku');
    const daftarBuku = document.getElementById('daftar-buku');
    const pesan = document.getElementById('pesan');

    const bolehKelolaBuku = @json(
        auth()->user()?->can('kelola-buku') ?? false
    );

    const bukuId = document.getElementById('buku-id');
    const kategoriId = document.getElementById('kategori_id');
    const judul = document.getElementById('judul');
    const penulis = document.getElementById('penulis');
    const tahun = document.getElementById('tahun_terbit');
    const judulForm = document.getElementById('judul-form');
    const tombolSimpan = document.getElementById('tombol-simpan');
    const tombolBatal = document.getElementById('tombol-batal');

    // MENAMPILKAN PESAN
    function tampilkanPesan(teks, jenis) {
        pesan.textContent = teks;
        pesan.className = 'pesan ' + jenis;
    }

    function bersihkanPesan() {
        pesan.textContent = '';
        pesan.className = 'pesan';
    }

    // MEMBACA RESPONS API
    async function bacaRespons(response) {

        const hasil = await response.json().catch(() => ({}));

        if (!response.ok) {

            const errors = hasil.errors
                ? Object.values(hasil.errors).flat().join('\n')
                : '';

            throw new Error(
                errors || hasil.message ||
                'Permintaan gagal. Silakan coba lagi.'
            );
        }

        return hasil;
    }

    // MEMBUAT ELEMEN HTML
    function buatElemen(tag, teks, className = '') {

        const elemen = document.createElement(tag);

        elemen.textContent = teks;

        if (className) {
            elemen.className = className;
        }

        return elemen;
    }

    // MEMBUAT TOMBOL AKSI
    function tombolAksi(teks, className, aksi) {

        const tombol = document.createElement('button');

        tombol.type = 'button';
        tombol.textContent = teks;
        tombol.className = 'tombol ' + className;

        tombol.addEventListener('click', aksi);

        return tombol;
    }

    // RESET FORM
    function resetForm() {

        if (!form) return;

        form.reset();

        bukuId.value = '';

        judulForm.textContent = 'Tambah Buku';

        tombolSimpan.textContent = 'Tambah Buku';

        tombolBatal.hidden = true;

        bersihkanPesan();
    }

    // MENGISI FORM KETIKA UBAH BUKU
    function isiFormUbah(item) {

        bersihkanPesan();

        bukuId.value = item.id;

        kategoriId.value = item.kategori_id ?? '';

        judul.value = item.judul ?? '';

        penulis.value = item.penulis ?? '';

        tahun.value = item.tahun_terbit ?? '';

        judulForm.textContent = 'Ubah Buku';

        tombolSimpan.textContent = 'Simpan Perubahan';

        tombolBatal.hidden = false;

        form.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    // MENGHAPUS BUKU
    async function hapusBuku(item) {

        const yakin = confirm(
            'Apakah kamu yakin ingin menghapus buku "' +
            item.judul + '"?'
        );

        if (!yakin) return;

        bersihkanPesan();

        try {

            const response = await fetch(
                API_URL + '/' + encodeURIComponent(item.id),
                {
                    method: 'DELETE',
                    credentials: 'same-origin',

                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            );

            const hasil = await bacaRespons(response);

            if (bukuId.value == item.id) {
                resetForm();
            }

            await muatBuku();

            tampilkanPesan(
                hasil.message || 'Buku berhasil dihapus.',
                'sukses'
            );

        } catch (error) {

            console.error('Kesalahan hapus buku:', error);

            tampilkanPesan(error.message, 'gagal');
        }
    }

    // MEMBUAT KARTU BUKU
    function buatKartu(item) {

        const kartu = document.createElement('div');

        kartu.className = 'kartu-buku';

        kartu.appendChild(
            buatElemen('h3', item.judul ?? 'Tanpa Judul')
        );

        kartu.appendChild(
            buatElemen(
                'p',
                'Penulis: ' + (item.penulis ?? '-')
            )
        );

        kartu.appendChild(
            buatElemen(
                'p',
                'Tahun Terbit: ' + (item.tahun_terbit ?? '-')
            )
        );

        // TOMBOL DETAIL
        const tautan = document.createElement('a');

        tautan.href = '/buku/' + encodeURIComponent(item.id);

        tautan.className = 'tombol tombol-detail';

        tautan.textContent = 'Lihat Detail';

        kartu.appendChild(tautan);

        // KATEGORI BUKU
        kartu.appendChild(
            buatElemen(
                'span',
                item.kategori ?? 'Tanpa Kategori',
                'kategori-buku'
            )
        );

        // TOMBOL UBAH DAN HAPUS
        if (bolehKelolaBuku) {

            const aksi = document.createElement('div');

            aksi.className = 'aksi-kartu';

            aksi.appendChild(
                tombolAksi(
                    'Ubah',
                    'tombol-ubah',
                    () => isiFormUbah(item)
                )
            );

            aksi.appendChild(
                tombolAksi(
                    'Hapus',
                    'tombol-hapus',
                    () => hapusBuku(item)
                )
            );

            kartu.appendChild(aksi);
        }

        return kartu;
    }

    // MENGAMBIL DATA BUKU DARI API
    async function muatBuku() {

        daftarBuku.replaceChildren(
            buatElemen(
                'p',
                'Memuat data buku...',
                'pesan-kosong'
            )
        );

        try {

            const response = await fetch(API_URL, {

                headers: {
                    'Accept': 'application/json'
                }

            });

            const hasil = await bacaRespons(response);

            const data = Array.isArray(hasil.data)
                ? hasil.data
                : (hasil.data?.data ?? []);

            daftarBuku.replaceChildren();

            if (data.length === 0) {

                daftarBuku.appendChild(
                    buatElemen(
                        'p',
                        'Belum ada data buku.',
                        'pesan-kosong'
                    )
                );

                return;
            }

            data.forEach(item => {

                daftarBuku.appendChild(
                    buatKartu(item)
                );

            });

        } catch (error) {

            console.error('Kesalahan memuat buku:', error);

            daftarBuku.replaceChildren(
                buatElemen(
                    'p',
                    'Data buku gagal dimuat.',
                    'pesan-kosong'
                )
            );

            tampilkanPesan(error.message, 'gagal');
        }
    }

    // PROSES TAMBAH DAN UBAH BUKU
    if (bolehKelolaBuku) {

        form.addEventListener('submit', async (event) => {

            event.preventDefault();

            bersihkanPesan();

            const sedangUbah = bukuId.value !== '';

            const data = {

                kategori_id: kategoriId.value,

                judul: judul.value.trim(),

                penulis: penulis.value.trim(),

                tahun_terbit: tahun.value

            };

            const url = sedangUbah

                ? API_URL + '/' + encodeURIComponent(bukuId.value)

                : API_URL;

            const method = sedangUbah ? 'PUT' : 'POST';

            tombolSimpan.disabled = true;

            try {

                const response = await fetch(url, {

                    method: method,

                    credentials: 'same-origin',

                    headers: {

                        'Content-Type': 'application/json',

                        'Accept': 'application/json',

                        'X-CSRF-TOKEN': csrfToken,

                        'X-Requested-With': 'XMLHttpRequest'

                    },

                    body: JSON.stringify(data)

                });

                const hasil = await bacaRespons(response);

                resetForm();

                await muatBuku();

                tampilkanPesan(

                    hasil.message || (

                        sedangUbah
                            ? 'Buku berhasil diperbarui.'
                            : 'Buku berhasil ditambahkan.'

                    ),

                    'sukses'

                );

            } catch (error) {

                console.error('Kesalahan simpan buku:', error);

                tampilkanPesan(error.message, 'gagal');

            } finally {

                tombolSimpan.disabled = false;

            }

        });

        // TOMBOL BATAL UBAH
        tombolBatal.addEventListener('click', resetForm);

    }

    // SEMUA PENGGUNA DAPAT MELIHAT DAFTAR BUKU
    muatBuku();

});
</script>

@endsection
