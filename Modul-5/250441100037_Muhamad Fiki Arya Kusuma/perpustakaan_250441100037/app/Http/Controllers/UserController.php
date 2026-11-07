<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        // HANYA AMBIL ROLE PETUGAS DAN SISWA
        $roles = Role::whereIn('name', ['petugas', 'siswa'])->get();
        return view('users.index', compact('users', 'roles'));
    }

public function updateRole(Request $request, int $id)
{
    $request->validate([
        'role' => 'required|in:petugas,siswa',
    ]);

    $user = User::findOrFail($id);

    // Mencegah Admin mengubah role dirinya sendiri
    if ($user->id === Auth::id()) {
        return redirect()->back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri!');
    }

    // CEK APAKAH USER MASIH MEMILIKI PINJAMAN BUKU AKTIF
    $masihAdaPinjaman = \App\Models\Peminjaman::where('user_id', $user->id)
        ->whereIn('status', ['diajukan', 'dipinjam', 'menunggu_kembali'])
        ->exists();

    if ($masihAdaPinjaman) {
        return redirect()->back()->with('error', 'Role user ini tidak bisa diubah karena masih memiliki transaksi peminjaman buku yang belum selesai!');
    }

    $user->syncRoles([$request->role]);

    return redirect()->back()->with('success', 'Role pengguna ' . $user->name . ' berhasil diubah!');
}
}