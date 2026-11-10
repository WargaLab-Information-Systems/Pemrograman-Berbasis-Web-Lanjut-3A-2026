<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Koleksi Buku - API & Fetch</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
        .btn-back { display: inline-block; margin-bottom: 15px; text-decoration: none; color: #555; }
        .btn { padding: 8px 14px; text-decoration: none; border-radius: 4px; color: white; font-size: 14px; display: inline-block; margin-right: 6px; font-weight: bold; }
        .btn-primary { background: #007bff; }
        .btn-success { background: #28a745; }
        .btn-info { background: #17a2b8; }
        .action-container { margin-bottom: 15px; display: flex; gap: 10px; flex-wrap: wrap; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/dashboard" class="btn-back">&larr; Kembali ke Dashboard</a>
        <h2>&#128218; Manajemen Koleksi Buku</h2>
        <p>Daftar seluruh koleksi buku perpustakaan. Klik tombol <strong>Lihat Detail</strong> untuk membaca informasi atau melakukan peminjaman.</p>

        <!-- Tombol Khusus Admin & Petugas -->
        @auth
            @if(auth()->user()->hasRole('admin|petugas'))
            <div class="action-container">
                <a href="{{ route('kelola.buku.create') }}" class="btn btn-success">+ Tambah Buku Baru</a>
                <a href="{{ route('kelola.buku.index') }}" class="btn btn-info">🛠️ Buka Panel Kelola Buku (CRUD)</a>
            </div>
            @endif
        @endauth

        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tabel-buku">
                <tr>
                    <td colspan="5" style="text-align: center;">Memuat data buku dari server...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        fetch('/api/buku')
            .then(response => response.json())
            .then(data => {
                let tbody = document.getElementById('tabel-buku');
                tbody.innerHTML = '';

                if (!data || data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Belum ada data buku di database.</td></tr>';
                    return;
                }

                data.forEach(buku => {
                    let namaKategori = '-';
                    if (buku.kategori) {
                        namaKategori = buku.kategori.nama_kategori || buku.kategori.nama || '-';
                    }

                    let aksiBtn = `<a href="/buku/${buku.id}" class="btn btn-primary">Lihat Detail</a>`;

                    tbody.innerHTML += `
                        <tr>
                            <td>${namaKategori}</td>
                            <td>${buku.judul}</td>
                            <td>${buku.penulis}</td>
                            <td>${buku.tahun_terbit}</td>
                            <td>${aksiBtn}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('tabel-buku').innerHTML = '<tr><td colspan="5" style="text-align: center; color: red;">Gagal memuat data buku.</td></tr>';
            });
    </script>
</body>
</html>