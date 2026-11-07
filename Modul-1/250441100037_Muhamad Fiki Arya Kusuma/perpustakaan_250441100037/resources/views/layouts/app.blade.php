<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan NIM 250441100037')</title>
    @vite(['resources/css/app.css'])
</head>
<body>

    <header class="main-header">
        <div class="logo">
            <h1>Perpustakaan Digital</h1>
        </div>
        <nav class="main-nav">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('buku.index') }}">Daftar Buku</a>
        </nav>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="main-footer">
        <p>&copy; 2026 Perpustakaan Digital - NIM: 250441100037. All Rights Reserved.</p>
    </footer>

</body>
</html>