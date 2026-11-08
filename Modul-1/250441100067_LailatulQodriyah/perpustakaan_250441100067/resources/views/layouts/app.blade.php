<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Perpustakaan')</title>

    @vite(['resources/css/app.css'])
</head>

<body>

    <header class="he3
    6ader">
        <div class="container">
            <h1>Perpustakaan ela</h1>
            <p>Tempat menemukan berbagai koleksi buku</p>
        </div>
    </header>

    <nav class="navbar">
        <div class="container nav-content">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('buku.index') }}">Daftar Buku</a>
        </div>
    </nav>

    <main class="container content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>Perpustakaan ela</p>
        </div>
    </footer>

</body>
</html>