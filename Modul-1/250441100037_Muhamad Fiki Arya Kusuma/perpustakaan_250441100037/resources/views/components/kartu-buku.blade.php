@props(['id', 'judul', 'penulis', 'tahunTerbit'])

<div class="card-buku">
    <h3>{{ $judul }}</h3>
    <p><strong>Penulis:</strong> {{ $penulis }}</p>
    <p><strong>Tahun Terbit:</strong> {{ $tahunTerbit }}</p>
    
    @if (isset($badge))
        <div class="card-badge">
            {{ $badge }}
        </div>
    @endif

    <div class="card-action">
        <a href="{{ route('buku.show', $id) }}" class="btn">Lihat Detail</a>
    </div>
</div>