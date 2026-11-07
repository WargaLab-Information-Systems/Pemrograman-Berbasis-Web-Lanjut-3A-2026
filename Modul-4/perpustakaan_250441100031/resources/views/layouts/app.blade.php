<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital Modern</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-icon">📖</span> Pustaka<span class="highlight">Modern</span>
            </a>
            <nav class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                <a href="{{ route('buku.index') }}" class="nav-link">Daftar Buku</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; 2026 <strong>PustakaModern</strong>. Dibuat dengan cinta untuk Tugas PBWL.</p>
    </footer>
</body>
</html>