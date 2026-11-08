<x-app-layout>

    <style>
        body {
            background-color: #dcdafa;
            font-family: Arial, sans-serif;
        }

        .dashboard-perpus {
            background: #dcdafa;
            min-height: 85vh;
            padding: 20px 13px;
        }

        .container-dashboard {
            max-width: 1200px;
            margin: auto;
        }

        .judul-dashboard {
            color: #754b32;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .sambutan {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 22px;
        }

        .sambutan h1 {
            color: #754b32;
            font-size: 19px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .sambutan p {
            color: #666;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .label-role {
            display: inline-block;
            background: #efdbc3;
            color: #76553b;
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 11px;
        }

        .judul-menu {
            color: #754b32;
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .menu-dashboard {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .kartu-menu {
            background: white;
            padding: 18px;
            min-height: 135px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: 0.2s;
        }

        .kartu-menu:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.12);
        }

        .kartu-menu h3 {
            color: #754b32;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 9px;
        }

        .kartu-menu p {
            color: #333;
            font-size: 12px;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .tombol-menu {
            display: inline-block;
            background: #91613f;
            color: white;
            padding: 7px 11px;
            border-radius: 6px;
            font-size: 11px;
            width: fit-content;
        }

        .kartu-menu:hover .tombol-menu {
            background: #70472e;
        }

        @media(max-width: 950px) {
            .menu-dashboard {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media(max-width: 700px) {
            .menu-dashboard {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media(max-width: 450px) {
            .menu-dashboard {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-perpus">
        <div class="container-dashboard">

            <h2 class="judul-dashboard">
                Dashboard Perpustakaan
            </h2>

            {{-- SAMBUTAN --}}
            <div class="sambutan">
                <h1>
                    Selamat Datang, {{ Auth::user()->name }}!
                </h1>

                <p>
                    Selamat datang di Sistem Informasi Perpustakaan.
                    Silakan gunakan menu yang tersedia sesuai hak akses akunmu.
                </p>

                @role('admin')
                    <span class="label-role">Administrator</span>
                @endrole

                @role('petugas')
                    <span class="label-role">Petugas Perpustakaan</span>
                @endrole

                @role('siswa')
                    <span class="label-role">Siswa</span>
                @endrole
            </div>


            {{-- DASHBOARD ADMIN --}}
            @role('admin')

                <h2 class="judul-menu">Menu Pengelolaan Admin</h2>

                <div class="menu-dashboard">

                    <a href="{{ route('buku.index') }}" class="kartu-menu">
                        <div>
                            <h3>Manajemen Buku</h3>
                            <p>Melihat, menambah, mengubah, dan menghapus data buku.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="kartu-menu">
                        <div>
                            <h3>Manajemen Pengguna</h3>
                            <p>Mengelola akun pengguna dan menetapkan role.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('admin.pengajuan') }}" class="kartu-menu">
                        <div>
                            <h3>Pengajuan Peminjaman</h3>
                            <p>Melihat, menyetujui, dan menolak pengajuan peminjaman siswa.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('admin.peminjaman') }}" class="kartu-menu">
                        <div>
                            <h3>Data Peminjaman</h3>
                            <p>Melihat transaksi peminjaman buku.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('admin.pengembalian') }}" class="kartu-menu">
                        <div>
                            <h3>Data Pengembalian</h3>
                            <p>Melihat riwayat buku yang telah dikembalikan.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('admin.laporan') }}" class="kartu-menu">
                        <div>
                            <h3>Laporan Perpustakaan</h3>
                            <p>Melihat ringkasan data dan aktivitas perpustakaan.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                </div>
            @endrole


            {{-- DASHBOARD PETUGAS --}}
            @role('petugas')

                <h2 class="judul-menu">Menu Petugas</h2>

                <div class="menu-dashboard">

                    <a href="{{ route('buku.index') }}" class="kartu-menu">
                        <div>
                            <h3>Daftar Buku</h3>
                            <p>Melihat dan mengelola koleksi buku perpustakaan.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('admin.pengajuan') }}" class="kartu-menu">
                        <div>
                            <h3>Pengajuan Peminjaman</h3>
                            <p>Memproses persetujuan atau penolakan pengajuan siswa.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('admin.peminjaman') }}" class="kartu-menu">
                        <div>
                            <h3>Data Peminjaman</h3>
                            <p>Melihat transaksi peminjaman buku.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('admin.pengembalian') }}" class="kartu-menu">
                        <div>
                            <h3>Data Pengembalian</h3>
                            <p>Melihat riwayat pengembalian buku.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('admin.laporan') }}" class="kartu-menu">
                        <div>
                            <h3>Laporan Perpustakaan</h3>
                            <p>Melihat laporan dan ringkasan aktivitas perpustakaan.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                </div>
            @endrole


            {{-- DASHBOARD SISWA --}}
            @role('siswa')

                <h2 class="judul-menu">Menu Siswa</h2>

                <div class="menu-dashboard">

                    <a href="{{ route('buku.index') }}" class="kartu-menu">
                        <div>
                            <h3>Koleksi Buku</h3>
                            <p>Melihat daftar buku yang tersedia di perpustakaan.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('siswa.peminjaman.index') }}" class="kartu-menu">
                        <div>
                            <h3>Ajukan Peminjaman</h3>
                            <p>Mengajukan peminjaman buku ke petugas perpustakaan.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('siswa.peminjaman.riwayat') }}" class="kartu-menu">
                        <div>
                            <h3>Status dan Riwayat Peminjaman</h3>
                            <p>Melihat status pengajuan dan riwayat peminjaman buku.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="kartu-menu">
                        <div>
                            <h3>Profil Saya</h3>
                            <p>Melihat dan memperbarui informasi akun.</p>
                        </div>
                        <span class="tombol-menu">Buka Menu</span>
                    </a>

                </div>
            @endrole

        </div>
    </div>

</x-app-layout>