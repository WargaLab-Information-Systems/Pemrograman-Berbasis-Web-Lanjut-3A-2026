<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan - @yield('title', 'Beranda')</title>

    {{-- Vite: buat load file CSS --}}
    @vite(['resources/css/app.css'])
</head>
<body>

    {{-- HEADER --}}
    <header class="header">
        <div class="header-inner">
            <h1> Perpustakaan Digital</h1>
            <p class="tagline">Koleksi buku pilihan untukmu</p>
        </div>
    </header>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <a href="{{ route('home') }}" class="nav-link">Beranda</a>
        <a href="{{ route('buku.index') }}" class="nav-link">Daftar Buku</a>
    </nav>

    {{-- KONTEN --}}
    <main class="konten">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="footer">
        <p>&copy; {{ date('Y') }} Perpustakaan Digital -250441100117</p>
    </footer>

</body>
</html>