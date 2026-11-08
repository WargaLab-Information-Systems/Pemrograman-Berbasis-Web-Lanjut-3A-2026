<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Menampilkan semua pengguna
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form tambah pengguna
    public function create()
    {
        $roles = Role::where('guard_name', 'web')->get();

        return view('admin.users.create', compact('roles'));
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => [
                'required',
                Rule::exists('roles', 'name')
                    ->where('guard_name', 'web'),
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Menampilkan form edit pengguna
    public function edit(User $user)
    {
        $roles = Role::where('guard_name', 'web')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Memperbarui data pengguna
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8',
            'role' => [
                'required',
                Rule::exists('roles', 'name')
                    ->where('guard_name', 'web'),
            ],
        ]);

        if (auth()->id() == $user->id && $validated['role'] != 'admin') {
            return back()->with('error', 'Kamu tidak dapat mengubah role Admin milik akun sendiri.');
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Kamu tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
