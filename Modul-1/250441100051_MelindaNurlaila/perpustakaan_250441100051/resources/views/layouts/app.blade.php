<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title') - Perpustakaan
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <header class="site-header">

        <div class="container navbar">

            <div class="brand">

                <h1>Perpustakaan</h1>

                <p>Sistem Informasi Perpustakaan</p>

            </div>

            <nav class="navigation">

                <a href="{{ route('home') }}" class="nav-link">
                    Beranda
                </a>

                <a href="{{ route('buku.index') }}" class="nav-link">
                    Daftar Buku
                </a>

            </nav>

        </div>

    </header>

    <main class="container main-content">

        @yield('content')

    </main>

    <footer class="site-footer">

        <div class="container">

            <p>Perpustakaan</p>

            <span>Sistem Informasi Perpustakaan</span>

        </div>

    </footer>

</body>

</html>