<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Peminjaman</title>
</head>
<body>
    <h2>Detail Peminjaman</h2>

    <p>ID Peminjaman: {{ $peminjaman->id }}</p>
    <p>ID Anggota: {{ $peminjaman->anggota_id }}</p>
    <p>ID Buku: {{ $peminjaman->buku_id }}</p>
    <p>Tanggal Pinjam: {{ $peminjaman->tanggal_pinjam }}</p>
    <p>Status: {{ $peminjaman->status }}</p>
</body>
</html>