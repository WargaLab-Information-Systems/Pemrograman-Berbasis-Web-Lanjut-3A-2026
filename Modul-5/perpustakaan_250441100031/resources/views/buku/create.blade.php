<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku Baru</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn-back { background: #6c757d; text-decoration: none; display: inline-block; padding: 10px 15px; color: white; border-radius: 4px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>➕ Tambah Buku Baru</h2>
        
        <form action="{{ route('kelola.buku.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Kategori Buku:</label>
                <select name="kategori_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori ?? $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Judul Buku:</label>
                <input type="text" name="judul" required>
            </div>

            <div class="form-group">
                <label>Penulis:</label>
                <input type="text" name="penulis" required>
            </div>

            <div class="form-group">
                <label>Tahun Terbit:</label>
                <input type="number" name="tahun_terbit" required>
            </div>

            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="deskripsi" rows="4"></textarea>
            </div>

            <button type="submit" class="btn">Simpan Buku</button>
        </form>

        <a href="{{ route('buku.index') }}" class="btn-back">← Kembali</a>
    </div>
</body>
</html>