@extends('layouts.buku')

@section('title', 'Daftar Buku')

@section('content')
<h1><b>Daftar Buku</b></h1>

<div id="pesan" role="status">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    @endif
</div>

@can('kelola data buku')
<h3>Tambah Buku</h3>

<form id="form-buku">
    <div class="form-group mb-3">
        <label for="kategori_id">Kategori</label>
        <select id="kategori_id" name="kategori_id" class="form-control" required>
            <option value="">Pilih kategori</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul"
            class="form-control" minlength="3" maxlength="150" required>
    </div>

    <div class="form-group mb-3">
        <label for="penulis">Penulis</label>
        <input type="text" id="penulis" name="penulis"
            class="form-control" minlength="3" maxlength="100" required>
    </div>

    <div class="form-group mb-3">
        <label for="tahun_terbit">Tahun Terbit</label>
        <input type="number" id="tahun_terbit" name="tahun_terbit"
            class="form-control" min="1900" max="2026" required>
    </div>

    <button type="submit" id="tombol-simpan" class="btn btn-primary">
        Tambah Buku
    </button>
</form>
@endcan
<hr>

<h3>Daftar Buku</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Tahun Terbit</th>
            @if (auth()->user()->can('kelola data buku') || auth()->user()->can('mengajukan peminjaman buku'))
            <th>
                {{ auth()->user()->can('kelola data buku') ? 'Aksi' : 'Peminjaman' }}
            </th>
            @endif
        </tr>
    </thead>
    <tbody id="daftar-buku">
        @foreach ($buku as $item)
        <tr>
            <td>-</td>
            <td>{{ $item->judul }}</td>
            <td>{{ $item->penulis }}</td>
            <td>{{ $item->tahun_terbit }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    const daftarBuku = document.getElementById('daftar-buku');
    const pesan = document.getElementById('pesan');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const bolehKelolaBuku = @json(auth() -> user() -> can('kelola data buku'));

    const bolehMengajukan = @json(auth() -> user() -> can('mengajukan peminjaman buku'));

    const formBuku = document.getElementById('form-buku');
    const pilihanKategori = document.getElementById('kategori_id');
    let idBukuDiedit = null;

    async function ambilKategori() {
        try {
            const response = await fetch('/api/kategori', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil kategori.');
            }

            const kategori = await response.json();

            kategori.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.nama;
                pilihanKategori.appendChild(option);
            });
        } catch (error) {
            pesan.textContent = error.message;
        }
    }

    async function tampilkanBuku() {
        try {
            const response = await fetch('/api/buku', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data buku.');
            }

            const hasil = await response.json();
            const buku = hasil.data;

            daftarBuku.innerHTML = '';

            if (!buku || buku.length === 0) {
                daftarBuku.innerHTML =
                    `<tr><td colspan="${(bolehKelolaBuku || bolehMengajukan) ? 5 : 4}">Belum ada data buku.</td></tr>`;
                return;
            }

            buku.forEach(item => {
                const baris = document.createElement('tr');

                [
                    item.kategori,
                    item.judul,
                    item.penulis,
                    item.tahun_terbit
                ].forEach(nilai => {
                    const kolom = document.createElement('td');
                    kolom.textContent = nilai ?? '-';
                    baris.appendChild(kolom);
                });


                if (bolehKelolaBuku || bolehMengajukan) {
                    const kolomAksi = document.createElement('td');

                    if (bolehKelolaBuku) {
                        const tombolUbah = document.createElement('button');
                        tombolUbah.textContent = 'Ubah';
                        tombolUbah.type = 'button';
                        tombolUbah.className = 'btn btn-warning btn-sm mr-1';

                        tombolUbah.addEventListener('click', () => {
                            isiFormUbah(item);
                        });

                        const tombolHapus = document.createElement('button');
                        tombolHapus.textContent = 'Hapus';
                        tombolHapus.type = 'button';
                        tombolHapus.className = 'btn btn-danger btn-sm';

                        tombolHapus.addEventListener('click', () => {
                            hapusBuku(item.id);
                        });

                        kolomAksi.appendChild(tombolUbah);
                        kolomAksi.appendChild(tombolHapus);
                    }

                    if (bolehMengajukan) {
                        const formPeminjaman = document.createElement('form');
                        formPeminjaman.method = 'POST';
                        formPeminjaman.action = '/peminjaman';

                        const token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = '_token';
                        token.value = csrfToken;

                        const bukuId = document.createElement('input');
                        bukuId.type = 'hidden';
                        bukuId.name = 'buku_id';
                        bukuId.value = item.id;

                        const tombolAjukan = document.createElement('button');
                        tombolAjukan.type = 'submit';
                        tombolAjukan.textContent = 'Ajukan Peminjaman';
                        tombolAjukan.className = 'btn btn-success btn-sm';

                        formPeminjaman.appendChild(token);
                        formPeminjaman.appendChild(bukuId);
                        formPeminjaman.appendChild(tombolAjukan);

                        kolomAksi.appendChild(formPeminjaman);
                    }

                    baris.appendChild(kolomAksi);

                }

                daftarBuku.appendChild(baris);

            });

        } catch (error) {
            pesan.textContent = error.message;
            daftarBuku.innerHTML =
                `<tr><td colspan="${(bolehKelolaBuku || bolehMengajukan) ? 5 : 4}">Data buku gagal dimuat....</td></tr>`;
        }
    }


    function isiFormUbah(item) {
        idBukuDiedit = item.id;

        pilihanKategori.value = item.kategori_id ?? '';

        document.getElementById('judul').value = item.judul;
        document.getElementById('penulis').value = item.penulis;
        document.getElementById('tahun_terbit').value = item.tahun_terbit;

        document.getElementById('pesan').textContent =
            'Sedang mengubah buku: ' + item.judul;

        formBuku.scrollIntoView({
            behavior: 'smooth'
        });

        document.getElementById('tombol-simpan').textContent = 'Simpan Perubahan';
    }


    async function hapusBuku(id) {
        const yakin = confirm('Apakah kamu yakin ingin menghapus buku ini?');

        if (!yakin) {
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/buku/${id}`;

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = csrfToken;

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';

        form.appendChild(token);
        form.appendChild(method);

        document.body.appendChild(form);
        form.submit();
    }

    if (bolehKelolaBuku) {
        formBuku.addEventListener('submit', async function(event) {
            event.preventDefault();
            pesan.textContent = '';

            const dataBuku = {
                kategori_id: Number(pilihanKategori.value),
                judul: document.getElementById('judul').value,
                penulis: document.getElementById('penulis').value,
                tahun_terbit: Number(
                    document.getElementById('tahun_terbit').value
                )
            };

            const sedangMengubah = idBukuDiedit !== null;
            const url = sedangMengubah ?
                `/api/buku/${idBukuDiedit}` :
                '/api/buku';

            try {
                const response = await fetch(url, {
                    method: sedangMengubah ? 'PUT' : 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(dataBuku)
                });

                const hasil = await response.json();

                if (!response.ok) {
                    const errors = hasil.errors ?
                        Object.values(hasil.errors).flat().join(' ') :
                        hasil.message || 'Gagal menyimpan buku.';

                    throw new Error(errors);
                }

                pesan.textContent = sedangMengubah ?
                    'Buku berhasil diperbarui.' :
                    'Buku berhasil ditambahkan.';

                formBuku.reset();
                idBukuDiedit = null;

                document.getElementById('tombol-simpan').textContent = 'Tambah Buku';

                window.location.reload();

            } catch (error) {
                pesan.textContent = error.message;
            }
        });
    }

    if (bolehKelolaBuku) {
        ambilKategori();
    }

    tampilkanBuku();
</script>
@endsection