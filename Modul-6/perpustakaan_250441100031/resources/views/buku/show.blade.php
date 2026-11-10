<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - {{ $buku->judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 750px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; gap: 25px; flex-wrap: wrap; align-items: flex-start; }
        .book-cover { width: 220px; height: 320px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; background: #eee; }
        .book-info { flex: 1; min-width: 280px; }
        h2 { color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-top: 0; }
        p { line-height: 1.6; font-size: 15px; margin: 10px 0; }
        .btn { display: inline-block; padding: 10px 18px; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; font-weight: bold; border: none; cursor: pointer; }
        .btn-pinjam { background: #28a745; margin-right: 10px; }
        .btn-back { background: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Kolom Menampilkan Gambar dari Kolom 'gambar' di Database -->
        <div>
            @if(!empty($buku->gambar))
                <img src="{{ $buku->gambar }}" alt="Cover {{ $buku->judul }}" class="book-cover">
            @else
                <div class="book-cover" style="display: flex; align-items: center; justify-content: center; text-align: center; color: #777;">Tidak Ada Gambar</div>
            @endif
        </div>

        <!-- Kolom Informasi Detail Buku -->
        <div class="book-info">
            <h2>📖 Detail Buku</h2>
            <p><strong>Judul:</strong> {{ $buku->judul }}</p>
            <p><strong>Kategori:</strong> {{ $buku->kategori->nama_kategori ?? $buku->kategori->nama ?? '-' }}</p>
            <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
            <p><strong>Deskripsi:</strong> {{ $buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}</p>

            <!-- Tombol Peminjaman khusus untuk Akun Siswa -->
            @auth
                @if(auth()->user()->hasRole('siswa'))
                <form action="{{ route('siswa.peminjaman.ajukan', $buku->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-pinjam" onclick="return confirm('Apakah Anda yakin ingin mengajukan peminjaman buku ini?')">📥 Ajukan Peminjaman</button>
                </form>
                @endif
            @endauth

            <a href="{{ route('buku.index') }}" class="btn btn-back">&larr; Kembali ke Daftar Buku</a>
        </div>
    </div>
</body>
</html>