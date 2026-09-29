@props(['buku'])

<div class="kartu">
    <div class="kartu-header">
        <h3>{{ $buku['judul'] }}</h3>
    </div>

    <div class="kartu-body">
        <p class="kartu-info">
            <span class="label">Penulis</span>
            <span class="nilai">{{ $buku['penulis'] }}</span>
        </p>
        <p class="kartu-info">
            <span class="label">Tahun Terbit</span>
            <span class="nilai">{{ $buku['tahun'] }}</span>
        </p>
    </div>

    <div class="kartu-footer">
        <a href="{{ route('buku.show', $buku['id']) }}" class="tombol-detail">
            Lihat Detail →
        </a>
    </div>

    {{-- Slot tambahan --}}
    @if ($slot->isNotEmpty())
        <div class="kartu-slot">
            {{ $slot }}
        </div>
    @endif
</div>