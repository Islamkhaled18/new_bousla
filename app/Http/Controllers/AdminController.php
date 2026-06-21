<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;
use App\Traits\ToggleStatusTrait;

class AdminController extends Controller
{
    use ToggleStatusTrait;

    private const CACHE_KEY = 'admins_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function index()
    {
        $admins = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return User::where('type', 'admin')->select('id', 'full_name', 'email', 'phone', 'slug', 'is_active')
                ->with('roles')
                ->orderBy('id', 'DESC')
                ->get();
        });

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

        // Clear cache after adding
        Cache::forget(self::CACHE_KEY);

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

        // Clear cache after updating
        Cache::forget(self::CACHE_KEY);

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

        // Clear cache after deleting
        Cache::forget(self::CACHE_KEY);

        return redirect()->route('admins.index')
            ->with('success', 'تم حذف المشرف بنجاح');
    }

    public function toggleStatus(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admins.index')
                ->with('error', 'لا يمكنك تعديل حالة حسابك الخاص');
        }

        // Clear cache when status is toggled
        Cache::forget(self::CACHE_KEY);

        return $this->toggleStatusModel($admin);
    } //end of toggleStatus
}
