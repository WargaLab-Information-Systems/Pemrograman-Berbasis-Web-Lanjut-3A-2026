<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #ffc107; border-bottom: 2px solid #ffc107; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 10px 15px; background: #ffc107; color: black; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-back { background: #6c757d; text-decoration: none; display: inline-block; padding: 10px 15px; color: white; border-radius: 4px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>✏️ Edit Buku</h2>
        
        <form action="{{ route('kelola.buku.update', $buku->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Kategori Buku:</label>
                <select name="kategori_id" required>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $buku->kategori_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori ?? $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Judul Buku:</label>
                <input type="text" name="judul" value="{{ $buku->judul }}" required>
            </div>

            <div class="form-group">
                <label>Penulis:</label>
                <input type="text" name="penulis" value="{{ $buku->penulis }}" required>
            </div>

            <div class="form-group">
                <label>Tahun Terbit:</label>
                <input type="number" name="tahun_terbit" value="{{ $buku->tahun_terbit }}" required>
            </div>

            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="deskripsi" rows="4">{{ $buku->deskripsi }}</textarea>
            </div>

            <button type="submit" class="btn">Perbarui Buku</button>
        </form>

        <a href="{{ route('buku.index') }}" class="btn-back">← Kembali</a>
    </div>
</body>
</html>