<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            ['name' => 'user_view', 'group' => 'user'],
            ['name' => 'user_create', 'group' => 'user'],
            ['name' => 'user_edit', 'group' => 'user'],
            ['name' => 'user_delete', 'group' => 'user'],

            // Role permissions
            ['name' => 'role_view', 'group' => 'role'],
            ['name' => 'role_create', 'group' => 'role'],
            ['name' => 'role_edit', 'group' => 'role'],
            ['name' => 'role_delete', 'group' => 'role'],

            // Permission permissions
            ['name' => 'permission_view', 'group' => 'permission'],
            ['name' => 'permission_create', 'group' => 'permission'],
            ['name' => 'permission_edit', 'group' => 'permission'],
            ['name' => 'permission_delete', 'group' => 'permission'],

            // Additional permissions can be added here
            ['name' => 'settings_manage', 'group' => 'system'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'Admin', 'description' => 'Super Administrator']);
        $adminRole->givePermissionTo(Permission::all());

        $userRole = Role::create(['name' => 'User', 'description' => 'Regular User']);
        $userRole->givePermissionTo([
            'user_view',
            'role_view',
            'permission_view'
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'active' => true
        ]);
        $admin->assignRole($adminRole);

        // Create regular user
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'active' => true
        ]);
        $user->assignRole($userRole);

        // Optionally create more roles
        $managerRole = Role::create(['name' => 'Manager', 'description' => 'Department Manager']);
        $managerRole->givePermissionTo([
            'user_view',
            'user_create',
            'user_edit',
            'role_view',
        ]);
    }
}
