<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('-', $permission->name)[1] ?? 'other';
        });
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create(['name' => $validated['name'], 'guard_name' => 'web']);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Ruxsat muvaffaqiyatli yaratildi!');
    }

    public function show(Permission $permission)
    {
        // Permission qaysi rollarga biriktirilgan
        $roles = $permission->roles()->with('users')->get();
        
        // Permission qaysi foydalanuvchilarga to'g'ridan-to'g'ri biriktirilgan
        $users = $permission->users()->get();
        
        return view('admin.permissions.show', compact('permission', 'roles', 'users'));
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $validated['name']]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Ruxsat muvaffaqiyatli yangilandi!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Ruxsat muvaffaqiyatli o\'chirildi!');
    }
}
