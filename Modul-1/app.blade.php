<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan')</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <header>
        <h1>Perpustakaan Digital</h1>
        <p>Sistem Informasi Perpustakaan</p>
    </header>

    <nav style="display: flex; justify-content: center; gap: 20px;">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('buku.index') }}">Daftar Buku</a>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Perpustakaan_250441100071</p>
    </footer>
</body>
</html>