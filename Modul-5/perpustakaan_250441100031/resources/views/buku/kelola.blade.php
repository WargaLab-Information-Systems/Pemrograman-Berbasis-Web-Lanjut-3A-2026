<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - Admin & Petugas</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; color: white; font-size: 14px; display: inline-block; margin-right: 4px; }
        .btn-success { background: #28a745; margin-bottom: 15px; }
        .btn-warning { background: #ffc107; color: black; font-weight: bold; }
        .btn-danger { background: #dc3545; border: none; cursor: pointer; }
        .btn-back { background: #6c757d; display: inline-block; margin-bottom: 15px; }
        .alert-success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/dashboard" class="btn btn-back">&larr; Kembali ke Dashboard</a>
        <h2>🛠️ Panel Kelola Buku (Admin & Petugas)</h2>

        <a href="{{ route('kelola.buku.create') }}" class="btn btn-success">+ Tambah Buku Baru</a>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Aksi (Update & Hapus)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bukus as $index => $buku)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ $buku->tahun_terbit }}</td>
                    <td>
                        <!-- Tombol Update / Edit Buku -->
                        <a href="{{ route('kelola.buku.edit', $buku->id) }}" class="btn btn-warning">Edit / Update</a>
                        
                        <!-- Tombol Hapus Buku -->
                        <form action="{{ route('kelola.buku.destroy', $buku->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>