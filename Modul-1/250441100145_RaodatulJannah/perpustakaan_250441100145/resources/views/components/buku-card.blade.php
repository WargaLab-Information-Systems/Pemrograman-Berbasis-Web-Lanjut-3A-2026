<div class="book-card">

    <div class="book-icon">
        📚
    </div>

    <div class="book-content">

        <h3>{{ $buku['judul'] }}</h3>

        <p>
            <strong>Penulis:</strong>
            {{ $buku['penulis'] }}
        </p>

        <p>
            <strong>Tahun Terbit:</strong>
            {{ $buku['tahun'] }}
        </p>

        <p>
            <strong>Kategori:</strong>
            {{ $buku['kategori'] }}
        </p>

        <div class="book-action">
            {{ $action }}
        </div>

    </div>

</div>