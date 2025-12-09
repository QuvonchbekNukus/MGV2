<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Cache ni tozalash
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissionlarni yaratish
        $permissions = [
            // User permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Role permissions
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            // Permission permissions
            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',

            // Activity Log permissions
            'view-activity-logs',
            'export-activity-logs',
            'delete-activity-logs',

            // Dashboard
            'view-dashboard',

            // Settings
            'view-settings',
            'edit-settings',

            // Reports
            'view-reports',
            'export-reports',

            // Content Management
            'view-posts',
            'create-posts',
            'edit-posts',
            'delete-posts',
            'publish-posts',

            // Group permissions
            'view-groups',
            'create-groups',
            'edit-groups',
            'delete-groups',

            // Lesson permissions
            'view-lessons',
            'create-lessons',
            'edit-lessons',
            'delete-lessons',

            // Toy permissions
            'view-toys',
            'create-toys',
            'edit-toys',
            'delete-toys',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Super Admin roli yaratish (barcha ruxsatlarga ega)
        $superAdminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin roli
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            'view-dashboard',
            'view-users',
            'create-users',
            'edit-users',
            'view-roles',
            'view-permissions',
            'view-settings',
            'view-reports',
            'export-reports',
            'view-posts',
            'create-posts',
            'edit-posts',
            'publish-posts',
        ]);

        // Moderator roli
        $moderatorRole = Role::create(['name' => 'moderator', 'guard_name' => 'web']);
        $moderatorRole->givePermissionTo([
            'view-dashboard',
            'view-users',
            'view-posts',
            'edit-posts',
            'view-reports',
        ]);

        // Editor roli
        $editorRole = Role::create(['name' => 'editor', 'guard_name' => 'web']);
        $editorRole->givePermissionTo([
            'view-dashboard',
            'view-posts',
            'create-posts',
            'edit-posts',
        ]);

        // User roli (oddiy foydalanuvchi)
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);
        $userRole->givePermissionTo([
            'view-dashboard',
        ]);

        // Test foydalanuvchilarni yaratish

        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234567',
            'is_active' => true,
        ]);
        $superAdmin->assignRole($superAdminRole);

        // Admin
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234568',
            'is_active' => true,
        ]);
        $admin->assignRole($adminRole);

        // Moderator
        $moderator = User::create([
            'name' => 'Moderator User',
            'username' => 'moderator',
            'email' => 'moderator@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234569',
            'is_active' => true,
        ]);
        $moderator->assignRole($moderatorRole);

        // Editor
        $editor = User::create([
            'name' => 'Editor User',
            'username' => 'editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234570',
            'is_active' => true,
        ]);
        $editor->assignRole($editorRole);

        // Oddiy User
        $normalUser = User::create([
            'name' => 'Normal User',
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234571',
            'is_active' => true,
        ]);
        $normalUser->assignRole($userRole);
    }
}
