<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku - API & Fetch</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; color: #333; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .page-header { margin-bottom: 20px; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .card { background: #ffffff; border: 2px solid #007bff; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-control { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-info { background: #17a2b8; color: white; text-decoration: none; display: inline-block; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-danger { background: #dc3545; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f1f1f1; }
       
        #notif-box { padding: 12px 15px; border-radius: 5px; margin-bottom: 20px; display: none; font-weight: bold; }
        .notif-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .notif-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="container">
        <div class="page-header">
            <h2>📚 Manajemen Koleksi Buku (API & Fetch)</h2>
            <p>Praktikum Pemrograman Berbasis Web - CRUD dengan Dropdown Kategori & Validasi Penulis</p>
        </div>

        <div id="notif-box"></div>

        <div class="card">
            <h4 id="form-title" style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Formulir Tambah Buku</h4>
            <form id="form-buku">
                <input type="hidden" id="buku_id">
                
                <div class="form-group">
                    <label for="kategori_id">Nama Kategori</label>
                    <select id="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Nama Kategori --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="judul">Judul Buku</label>
                    <input type="text" id="judul" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="penulis">Penulis </label>
                    <input type="text" id="penulis" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="number" id="tahun_terbit" class="form-control" required>
                </div>
                
                <div style="border-top: 1px solid #eee; padding-top: 15px;">
                    <button type="submit" id="btn-submit" class="btn btn-primary">Simpan Buku</button>
                    <button type="button" id="btn-cancel" onclick="resetForm()" class="btn btn-secondary" style="display: none; margin-left: 5px;">Batal</button>
                </div>
            </form>
        </div>

        <h3>Daftar Buku</h3>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tabel-buku-body">
            </tbody>
        </table>
    </div>

    <script>
        function tampilkanPesan(pesan, tipe) {
            const notif = document.getElementById('notif-box');
            notif.innerText = pesan;
            notif.className = tipe === 'success' ? 'notif-success' : 'notif-error';
            notif.style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setTimeout(() => { notif.style.display = 'none'; }, 4000);
        }

        async function muatKategori() {
            try {
                const response = await fetch('/api/rekap/buku-per-kategori');
                if (!response.ok) throw new Error('Gagal memuat data kategori');

                const result = await response.json();
                const selectKategori = document.getElementById('kategori_id');
                
                selectKategori.innerHTML = '<option value="">-- Pilih Nama Kategori --</option>';
                
                result.data.forEach(kat => {
                    selectKategori.innerHTML += `<option value="${kat.id}">${kat.nama}</option>`;
                });
            } catch (error) {
                console.error('Error kategori:', error);
            }
        }

        async function muatDataBuku() {
            try {
                const response = await fetch('/api/buku');
                if (!response.ok) throw new Error('Gagal mengambil data dari endpoint API.');

                const result = await response.json();
                const tbody = document.getElementById('tabel-buku-body');
                tbody.innerHTML = '';

                result.data.forEach(buku => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${buku.kategori}</td>
                            <td>${buku.judul}</td>
                            <td>${buku.penulis}</td>
                            <td>${buku.tahun_terbit}</td>
                            <td style="text-align: center;">
                                <a href="/buku/${buku.id}" class="btn btn-info" style="padding: 5px 10px; font-size: 12px; margin-right: 3px;">Lihat</a>
                                <button class="btn btn-warning" onclick="pilihUbahBuku(${buku.id})" style="padding: 5px 10px; font-size: 12px; margin-right: 3px;">Ubah</button>
                                <button class="btn btn-danger" onclick="hapusBuku(${buku.id})" style="padding: 5px 10px; font-size: 12px;">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
            } catch (error) {
                console.error('Error:', error);
                tampilkanPesan('Terjadi kesalahan saat memuat data: ' + error.message, 'error');
            }
        }

        document.getElementById('form-buku').addEventListener('submit', async function(e) {
            e.preventDefault();

            const penulis = document.getElementById('penulis').value;

            if (!isNaN(penulis)) {
                tampilkanPesan('Validasi Gagal: Nama penulis tidak boleh berupa angka!', 'error');
                return;
            }

            const id = document.getElementById('buku_id').value;
            const data = {
                kategori_id: document.getElementById('kategori_id').value,
                judul: document.getElementById('judul').value,
                penulis: penulis,
                tahun_terbit: document.getElementById('tahun_terbit').value,
            };

            const url = id ? `/api/buku/${id}` : '/api/buku';
            const method = id ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                });

                if (!response.ok) {
                    const errData = await response.json();
                    let pesanError = errData.message || 'Gagal menyimpan data.';
                    if (errData.errors) {
                        pesanError += ' ' + Object.values(errData.errors).flat().join(', ');
                    }
                    throw new Error(pesanError);
                }

                tampilkanPesan(id ? 'Data buku berhasil diperbarui!' : 'Buku baru berhasil ditambahkan!', 'success');
                resetForm();
                muatDataBuku();
            } catch (error) {
                tampilkanPesan('Kesalahan: ' + error.message, 'error');
            }
        });

        async function pilihUbahBuku(id) {
            try {
                const response = await fetch(`/api/buku/${id}`);
                if (!response.ok) throw new Error('Gagal mengambil detail buku.');

                const result = await response.json();
                const buku = result.data;

                document.getElementById('buku_id').value = buku.id;
                document.getElementById('kategori_id').value = buku.kategori_id;
                document.getElementById('judul').value = buku.judul;
                document.getElementById('penulis').value = buku.penulis;
                document.getElementById('tahun_terbit').value = buku.tahun_terbit;

                document.getElementById('form-title').innerText = 'Formulir Ubah Buku (ID: ' + buku.id + ')';
                document.getElementById('btn-submit').innerText = 'Perbarui Buku';
                document.getElementById('btn-cancel').style.display = 'inline-block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } catch (error) {
                tampilkanPesan('Kesalahan: ' + error.message, 'error');
            }
        }

        async function hapusBuku(id) {
            if (!confirm('Yakin ingin menghapus buku ini?')) return;

            try {
                const response = await fetch(`/api/buku/${id}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) throw new Error('Gagal menghapus buku.');

                tampilkanPesan('Buku berhasil dihapus.', 'success');
                muatDataBuku();
            } catch (error) {
                tampilkanPesan('Kesalahan: ' + error.message, 'error');
            }
        }

        function resetForm() {
            document.getElementById('form-buku').reset();
            document.getElementById('buku_id').value = '';
            document.getElementById('form-title').innerText = 'Formulir Tambah Buku';
            document.getElementById('btn-submit').innerText = 'Simpan Buku';
            document.getElementById('btn-cancel').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            muatKategori();
            muatDataBuku();
        });
    </script>
</body>
</html>

