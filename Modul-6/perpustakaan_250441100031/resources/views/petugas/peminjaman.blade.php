<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Peminjaman - Petugas</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f6f9; }
        .container { background: white; padding: 25px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #17a2b8; color: white; }
        .btn-setuju { background: #28a745; color: white; padding: 5px 10px; border:none; border-radius:4px; cursor:pointer;}
        .btn-tolak { background: #dc3545; color: white; padding: 5px 10px; border:none; border-radius:4px; cursor:pointer;}
        .btn-kembali { background: #007bff; color: white; padding: 5px 10px; border:none; border-radius:4px; cursor:pointer;}
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 Kelola Peminjaman & Pengembalian Buku</h2>
        <a href="{{ route('petugas.dashboard') }}">← Kembali ke Dashboard</a>

        @if(session('success'))
            <div style="padding:10px; background:#d4edda; color:#155724; margin-top:10px;">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamans as $p)
                <tr>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->buku->judul ?? 'Buku Dihapus' }}</td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td><strong>{{ strtoupper($p->status) }}</strong></td>
                    <td>
                        @if($p->status === 'diproses')
                            <form action="{{ route('petugas.peminjaman.updateStatus', $p->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="dipinjam">
                                <button type="submit" class="btn-setuju">Setujui</button>
                            </form>
                            <form action="{{ route('petugas.peminjaman.updateStatus', $p->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="btn-tolak">Tolak</button>
                            </form>
                        @elseif($p->status === 'dipinjam')
                            <form action="{{ route('petugas.peminjaman.updateStatus', $p->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="dikembalikan">
                                <button type="submit" class="btn-kembali">Tandai Dikembalikan</button>
                            </form>
                        @else
                            <span>- Selesai -</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>