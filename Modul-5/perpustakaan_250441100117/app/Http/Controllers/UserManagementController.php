<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index(): View
    {
        // Ambil semua user beserta role-nya
        $users = User::with('roles')->orderBy('name')->get();
        // Ambil daftar role yang tersedia
        $roles = Role::whereIn('name', ['admin', 'petugas', 'siswa'])->get();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        // Validasi input role
        $request->validate([
            'role' => ['required', 'exists:roles,name'],
        ]);

        // Ganti role user
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui!');
    }
}