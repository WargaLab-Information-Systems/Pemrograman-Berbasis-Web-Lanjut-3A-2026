<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Perpustakaan IT Digital</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/perpus.css')
</head>

<body>

    <!-- Header dan Navbar -->
    <header class="header">
        <div class="container navbar">

            <h1>Perpustakaan IT Digital</h1>

            <nav>
                <a href="{{ route('home') }}">Beranda</a>

                @auth
                    @can('lihat daftar buku')
                        <a href="{{ route('buku.index') }}">Daftar Buku IT</a>
                    @endcan

                    @can('kelola data buku')
                        <a href="{{ route('buku.kelola') }}">Kelola Buku</a>
                    @endcan

                    <a href="{{ route('dashboard') }}">Dashboard</a>

                    <form method="POST" action="{{ route('logout') }}" class="nav-form">
                        @csrf
                        <button type="submit" class="nav-btn">Logout ({{ Auth::user()->name }})</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </nav>

        </div>
    </header>

    <!-- Konten -->
    <main class="container content">
        @if (session('status'))
            <div class="flash flash-ok">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="flash flash-err">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2026 Mustofa. All rights reserved.</p>
    </footer>

</body>
</html>
