<div class="card">
    @if(isset($buku['gambar']))
        <img src="{{ $buku['gambar'] }}" alt="{{ $buku['judul'] }}" style="width: 100%; height: 240px; object-fit: contain; background-color: #f8f6f3; border-radius: 8px; margin-bottom: 12px;">
    @endif

    <span class="badge">{{ $buku['kategori'] }}</span>
    <h3 style="margin: 10px 0 5px 0; color: #4a2c11;">{{ $buku['judul'] }}</h3>
    <p><strong>Penulis:</strong> {{ $buku['penulis'] }}</p>
    <p><strong>Tahun Terbit:</strong> {{ $buku['tahun_terbit'] }}</p>

    <a href="{{ route('buku.show', $buku['id']) }}" class="btn" style="display: block; text-align: center; margin-top: 15px;">Lihat Detail</a>
</div>