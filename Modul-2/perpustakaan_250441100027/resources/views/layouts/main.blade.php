<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    
    @vite(['resources/css/app.css'])
</head>
<body>

    <header class="header">
        <div class="container header-container">
            <h1> Perpustakaan Digital</h1>
            <nav class="navbar">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">Daftar Buku</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <p style="font-size: 0.88rem; opacity: 0.9;">&copy; {{ date('Y') }} Perpustakaan Digital </p>
    </footer>

</body>
</html>