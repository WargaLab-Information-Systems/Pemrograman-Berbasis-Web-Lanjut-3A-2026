<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    // Menampilkan daftar role
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    // Menampilkan form pengaturan permission
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        $role->load('permissions');

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    // Memperbarui permission role
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'integer',
                Rule::exists('permissions', 'id'),
            ],
        ]);

        $permissionIds = $validated['permissions'] ?? [];

        $permissions = Permission::whereIn('id', $permissionIds)->get();

        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Permission role berhasil diperbarui.');
    }
}
