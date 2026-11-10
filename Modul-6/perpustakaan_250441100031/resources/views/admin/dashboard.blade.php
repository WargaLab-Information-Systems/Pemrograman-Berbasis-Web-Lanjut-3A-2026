<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        .btn { display: inline-block; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🛠️ Dashboard Administrator</h2>
        <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
        
        <div style="margin: 20px 0;">
            <a href="{{ route('admin.users.index') }}" class="btn">👥 Kelola Pengguna & Role</a>
            <a href="{{ route('buku.index') }}" class="btn" style="background:#28a745;">📚 Kelola Data Buku</a>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:#dc3545; color:white; border:none; padding:10px 15px; border-radius:4px; cursor:pointer;">Logout</button>
        </form>
    </div>
</body>
</html>