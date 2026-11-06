<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles')->orderBy('name');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn ($w) => $w->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"));
        }

        return view('admin.users.index', [
            'users' => $query->paginate(10)->withQueryString(),
            'roles' => Role::orderBy('name')->pluck('name'),
        ]);
    }

    public function create()
    {
        return view('admin.users.create', ['roles' => Role::orderBy('name')->pluck('name')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['nullable', Rule::exists('roles', 'name')],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Menetapkan role butuh permission "kelola role pengguna"; kalau tidak ada, jadi siswa.
        $role = $request->user()->can('kelola role pengguna') ? ($data['role'] ?? 'siswa') : 'siswa';
        $user->assignRole($role);
        $user->ensureAnggota();

        return redirect()->route('admin.users.index')->with('status', "Pengguna {$user->name} berhasil dibuat sebagai {$role}.");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user->load('roles'), 'roles' => Role::orderBy('name')->pluck('name')]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'Data pengguna diperbarui.');
    }

    /** Mengubah role (butuh permission "kelola role pengguna"). */
    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::exists('roles', 'name')],
        ]);

        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Kamu tidak bisa mengubah role akunmu sendiri (supaya admin tidak terkunci).');
        }

        $user->syncRoles([$data['role']]);

        return back()->with('status', "Role {$user->name} diubah menjadi {$data['role']}.");
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Pengguna dihapus.');
    }
}
