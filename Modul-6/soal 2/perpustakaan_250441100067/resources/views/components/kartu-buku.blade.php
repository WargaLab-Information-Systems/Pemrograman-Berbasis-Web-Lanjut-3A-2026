<div class="book-card">

    <div class="book-info">
        <h3>{{ $judul }}</h3>

        <p><strong>Penulis:</strong> {{ $penulis }}</p>

        <p><strong>Tahun Terbit:</strong> {{ $tahun }}</p>

        <a href="{{ route('buku.show', $id) }}" class="btn">
            Lihat Detail
        </a>
    </div>

    {{ $slot }}

</div>