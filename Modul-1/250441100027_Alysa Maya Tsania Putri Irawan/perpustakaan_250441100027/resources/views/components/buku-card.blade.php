@props(['buku'])

<div class="card">
    @if(isset($buku['gambar']))
        <img src="{{ $buku['gambar'] }}" alt="{{ $buku['judul'] }}" style="width: 100%; height: 220px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;">
    @endif

    <span class="badge">{{ $buku['kategori'] }}</span>
    <h3 style="margin: 10px 0 5px 0; color: #4a2c11;">{{ $buku['judul'] }}</h3>
    <p><strong>Penulis:</strong> {{ $buku['penulis'] }}</p>
    <p><strong>Tahun Terbit:</strong> {{ $buku['tahun_terbit'] }}</p>

    <div style="margin-top: 15px;">
        {{ $slot }}
    </div>
</div>