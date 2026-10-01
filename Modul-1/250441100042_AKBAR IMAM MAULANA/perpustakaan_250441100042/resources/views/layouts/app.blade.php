<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan')</title>

     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <header class= "header">
        <h1>Perpustakaan Digital</h1>
        <p>Tempat membaca dan menemukan berbagai macam buku</p>
    </header>

    <nav class="navbar">
        <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('buku.index') }}">Daftar Buku</a>
        </div>
    </nav>

    <main class="container content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Perpustakaan Digital</p>
        </div>
    </footer>
    
</body>
</html>