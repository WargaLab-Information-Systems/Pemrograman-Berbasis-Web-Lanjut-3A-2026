@props(['id', 'judul', 'penulis', 'tahun'])

<div class="book-card">

    <h3>{{ $judul }}</h3>

    <p>Penulis: {{ $penulis }}</p>

    <p>Tahun Terbit: {{ $tahun }}</p>

    <div>
        {{ $slot }}
    </div>

    <a href="{{ route('buku.show', $id) }}">
        Lihat Detail
    </a>

</div>