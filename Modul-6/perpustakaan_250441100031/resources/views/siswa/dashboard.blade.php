<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        .btn { display: inline-block; padding: 10px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📖 Dashboard Siswa</h2>
        <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>

        <div style="margin: 20px 0;">
            <a href="{{ route('buku.index') }}" class="btn">📚 Lihat Katalog Buku & Pinjam</a>
            <a href="{{ route('siswa.riwayat') }}" class="btn" style="background:#17a2b8;">📖 Riwayat Peminjaman Saya</a>
            <a href="{{ route('profile.edit') }}" class="btn" style="background:#ffc107; color:black;">👤 Edit Profil Saya</a>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:#dc3545; color:white; border:none; padding:10px 15px; border-radius:4px; cursor:pointer;">Logout</button>
        </form>
    </div>
</body>
</html>