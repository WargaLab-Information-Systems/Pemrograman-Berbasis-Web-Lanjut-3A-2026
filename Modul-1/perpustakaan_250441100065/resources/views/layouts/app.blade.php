<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Perpustakaan IT Digital</title>

    @vite('resources/css/app.css')
</head>

<body>

    <!-- Header dan Navbar -->
    <header class="header">
        <div class="container navbar">

            <h1>Perpustakaan IT Digital</h1>

            <nav>
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('buku.index') }}">Daftar Buku IT</a>
            </nav>

        </div>
    </header>

    <!-- Konten -->
    <main class="container content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2026 Mustofa. All rights reserved.</p>
    </footer>

</body>
</html>
