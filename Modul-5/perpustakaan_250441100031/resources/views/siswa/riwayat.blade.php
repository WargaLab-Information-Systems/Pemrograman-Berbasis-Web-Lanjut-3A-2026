<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman Saya</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f6f9; }
        .container { background: white; padding: 25px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #28a745; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📖 Riwayat Peminjaman Saya</h2>
        <a href="{{ route('siswa.dashboard') }}">← Kembali ke Dashboard</a> | 
        <a href="{{ route('buku.index') }}">Lihat Katalog Buku</a>

        @if(session('success'))
            <div style="padding:10px; background:#d4edda; color:#155724; margin-top:10px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="padding:10px; background:#f8d7da; color:#721c24; margin-top:10px;">{{ session('error') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayats as $r)
                <tr>
                    <td>{{ $r->buku->judul ?? '-' }}</td>
                    <td>{{ $r->tanggal_pinjam }}</td>
                    <td>{{ $r->tanggal_kembali ?? '-' }}</td>
                    <td><strong>{{ strtoupper($r->status) }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada riwayat peminjaman buku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>