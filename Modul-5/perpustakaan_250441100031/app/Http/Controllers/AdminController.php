<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Menggunakan try-catch atau pengecekan agar jika tabel belum ada tidak langsung fatal error 500
        $totalPengguna = User::count();
        $totalBuku = class_exists(Buku::class) ? Buku::count() : 0;
        
        // Memastikan model Peminjaman mengambil data dengan aman
        try {
            $totalPeminjaman = Peminjaman::count();
        } catch (\Exception $e) {
            $totalPeminjaman = 0;
        }

        return view('admin.dashboard', compact('totalPengguna', 'totalBuku', 'totalPeminjaman'));
    }

    public function users()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::findOrFail($id);
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus satu-satunya Admin!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }
}