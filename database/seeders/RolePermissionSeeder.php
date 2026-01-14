<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $editPermission = Permission::create(['name' => 'edit job titles']);
        $viewPermission = Permission::create(['name' => 'view job titles']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($editPermission, $viewPermission);
        $userRole->givePermissionTo($viewPermission);

        // Assign role to user
        $user = User::find(1); // Example user with ID 1
        $user->assignRole('admin');
    }
}
