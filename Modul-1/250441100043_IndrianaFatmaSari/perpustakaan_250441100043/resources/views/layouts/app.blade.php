<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'perpustakaan')</title>

    @vite(['resources/css/app.css'])
</head>
<body>
    <header>
        <h1>Perpustakaan Kita</h1>
        <p>Temukan cerita yang ingin kamu baca.</p>
    </header>

    <nav>
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('buku.index') }}">Daftar Buku</a>
    </nav>
    
    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 Perpustakaan Kita</p>
    </footer>
    
</body>
</html>