@props(['judul', 'penulis', 'tahun', 'id', 'gambar', 'kategori'])

<div class="card-buku">
    <div class="card-img-wrapper">
        <img src="{{ $gambar }}" alt="{{ $judul }}" class="card-img">
        <span class="badge-kategori">{{ $kategori }}</span>
    </div>
    <div class="card-body">
        <h3 class="card-title">{{ $judul }}</h3>
        <p class="card-author">oleh <span>{{ $penulis }}</span></p>
        <p class="card-year">📅 Tahun Terbit: {{ $tahun }}</p>
        
        @if(isset($slot) && !$slot->isEmpty())
            <div class="card-slot">
                {{ $slot }}
            </div>
        @endif

        <a href="{{ route('buku.show', $id) }}" class="btn-card">
            Lihat Detail &rarr;
        </a>
    </div>
</div>