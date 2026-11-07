@props(['judul', 'penulis', 'tahun', 'gambar' => null])

@php
    $slug = \Illuminate\Support\Str::slug($judul);
    $cari = glob(public_path('images/buku/' . $slug . '.*'));
    $file = $cari ? basename($cari[0]) : null;
@endphp

<div class="book-card">

    @if ($file)
        <img
            src="{{ asset('images/buku/' . $file) }}"
            alt="Sampul buku {{ $judul }}"
            class="book-cover"
        >
    @else
        <div class="book-cover book-cover-placeholder">
            {{ mb_substr($judul, 0, 1) }}
        </div>
    @endif

    <div class="book-card-content">

        <h3>{{ $judul }}</h3>

        <p>
            <strong>Penulis:</strong>
            {{ $penulis }}
        </p>

        <p>
            <strong>Tahun Terbit:</strong>
            {{ $tahun }}
        </p>

        <div class="book-card-extra">
            {{ $slot }}
        </div>

    </div>

</div>