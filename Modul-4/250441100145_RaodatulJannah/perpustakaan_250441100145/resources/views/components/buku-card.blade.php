
<div class="book-card">

    <div class="book-cover">
        @if ($buku['id'] == 1)
            <img
                src="{{ asset('images/laskar pelangi.jpg')}}">
        @elseif ($buku['id'] == 2)
            <img
                src="{{ asset('images/bumi.jpg')}}">

        @elseif ($buku['id'] == 3)
            <img src="{{ asset('images/negeri 5 menara.jpg')}}">

        @elseif ($buku['id'] == 4)
            <img
                src="{{ asset('images/filosofi teras.jpg')}}">
        @else
            <img
                src="{{ asset('images/atomic habits.png')}}">

        @endif
        
    </div>

    <div class="book-content">
        <span class="book-category">
            {{ $buku['kategori'] }}
        </span>

        <h3>{{ $buku['judul'] }}</h3>

        <p class="book-author">
            Oleh {{ $buku['penulis'] }}
        </p>

        <p class="book-year">
            Tahun terbit: {{ $buku['tahun'] }}
        </p>

        <div class="book-action">
            {{ $action }}
        </div>
    </div>

</div>
