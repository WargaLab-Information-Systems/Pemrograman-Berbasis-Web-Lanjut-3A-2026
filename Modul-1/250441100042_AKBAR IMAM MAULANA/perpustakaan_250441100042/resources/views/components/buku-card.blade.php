 @props([
    'judul',
    'penulis',
    'tahun'
])

<div class="book-card">

    <h3>{{ $judul }}</h3>

    <p>
        <strong>Penulis:</strong>
        {{ $penulis }}
    </p>

    <p>
        <strong>Tahun Terbit:</strong>
        {{ $tahun }}
    </p>

    <div class="book-action">
        {{ $action }}
    </div>

</div>