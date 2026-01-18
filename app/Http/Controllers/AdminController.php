<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Traits\ToggleStatusTrait;


class AdminController extends Controller
{
    use ToggleStatusTrait;
    public function index()
    {
        $admins = User::with('roles')
            ->orderBy('id', 'DESC')
            ->paginate(15);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.admins.create', compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        $admin = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'type' => 'admin'
        ]);

        $admin->assignRole($request->roles_name);

        return redirect()->route('admins.index')
            ->with('success', 'تم اضافة المشرف بنجاح');
    }

    public function show(User $admin)
    {
        $admin->load('roles', 'permissions');
        $roles = Role::pluck('name', 'name')->all();
        $adminRoles = $admin->roles->pluck('name')->toArray();
        return view('admin.admins.show', compact('admin', 'roles', 'adminRoles'));
    }

    public function edit(User $admin)
    {
        $roles = Role::pluck('name', 'name')->all();
        $adminRoles = $admin->roles->pluck('name')->toArray();

        return view('admin.admins.edit', compact('admin', 'roles', 'adminRoles'));
    }

    public function update(AdminRequest $request, User $admin)
    {
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => 'admin'
        ];

        if ($request->filled('password') && $request->filled('current_password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        $admin->syncRoles($request->roles_name);

        return redirect()->route('admins.index')
            ->with('success', 'تم تحديث معلومات المشرف بنجاح');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admins.index')
                ->with('error', 'لا يمكنك حذف حسابك الخاص');
        }

        $admin->delete();

        return redirect()->route('admins.index')
            ->with('success', 'تم حذف المشرف بنجاح');
    }

    public function toggleStatus(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admins.index')
                ->with('error', 'لا يمكنك تعديل حالة حسابك الخاص');
        }
        return $this->toggleStatusModel($admin);
    } //end of toggleStatus
}
