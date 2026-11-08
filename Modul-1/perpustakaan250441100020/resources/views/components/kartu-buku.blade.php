<div class="kartu-buku">

    <h3 class="jarak">{{ $judul }}</h3>

    <p>Penulis: {{ $penulis }}</p>
    <p>Tahun Terbit: {{ $tahun }}</p>

    <div class="kategori">
        {{ $slot }}
    </div>

    <a href="/buku/{{ $id }}" class="tombol-detail">
        Lihat Detail
    </a>

</div>
