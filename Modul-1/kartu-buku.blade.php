<div class="kartu-buku">
    <h3>{{ $judul }}</h3>
    <p><strong>Penulis:</strong> {{ $penulis }}</p>
    <p><strong>Tahun:</strong> {{ $tahun }}</p>

    {{ $slot }}

    <a href="{{ $url }}" class="btn-detail">Lihat Detail</a>
</div>