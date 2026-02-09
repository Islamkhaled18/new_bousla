<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{
    private const CACHE_KEY = 'roles_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function index(Request $request): View
    {
        $roles = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return Role::orderByDesc('id')->get();
        });

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions(Permission::whereIn('id', $request->input('permission'))->get());

        // Clear cache after adding
        Cache::forget(self::CACHE_KEY);

        return redirect()
            ->route('roles.index')
            ->with('success', 'تم الحفظ بنجاح');
    }

    public function show(Role $role): View
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.show', compact('role', 'rolePermissions','permissions'));
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update(['name' => $request->input('name')]);

        $permissions = Permission::whereIn('id', $request->input('permission'))->get();
        $role->syncPermissions($permissions);

        // Clear cache after updating
        Cache::forget(self::CACHE_KEY);

        return redirect()
            ->route('roles.index')
            ->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        // Clear cache after deleting
        Cache::forget(self::CACHE_KEY);

        return redirect()
            ->route('roles.index')
            ->with('success', 'تم الحذف بنجاح');
    }
}