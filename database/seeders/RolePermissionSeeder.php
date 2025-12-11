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
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Super Admin roli yaratish (barcha ruxsatlarga ega)
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions(Permission::all());

        // Admin roli
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions([
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
        ]);

        // Moderator roli
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator', 'guard_name' => 'web']);
        $moderatorRole->syncPermissions([
            'view-dashboard',
            'view-users',
            'view-posts',
            'edit-posts',
            'view-reports',
        ]);

        // Editor roli
        $editorRole = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $editorRole->syncPermissions([
            'view-dashboard',
            'view-posts',
            'create-posts',
            'edit-posts',
        ]);

        // User roli (oddiy foydalanuvchi)
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userRole->syncPermissions([
            'view-dashboard',
        ]);

        // Test foydalanuvchilarni yaratish

        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('password'),
                'phone' => '+998901234567',
                'is_active' => true,
            ]
        );
        if (!$superAdmin->hasRole($superAdminRole)) {
            $superAdmin->assignRole($superAdminRole);
        }

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'phone' => '+998901234568',
                'is_active' => true,
            ]
        );
        if (!$admin->hasRole($adminRole)) {
            $admin->assignRole($adminRole);
        }

        // Moderator
        $moderator = User::firstOrCreate(
            ['email' => 'moderator@example.com'],
            [
                'name' => 'Moderator User',
                'username' => 'moderator',
                'password' => Hash::make('password'),
                'phone' => '+998901234569',
                'is_active' => true,
            ]
        );
        if (!$moderator->hasRole($moderatorRole)) {
            $moderator->assignRole($moderatorRole);
        }

        // Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor User',
                'username' => 'editor',
                'password' => Hash::make('password'),
                'phone' => '+998901234570',
                'is_active' => true,
            ]
        );
        if (!$editor->hasRole($editorRole)) {
            $editor->assignRole($editorRole);
        }

        // Oddiy User
        $normalUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'username' => 'user',
                'password' => Hash::make('password'),
                'phone' => '+998901234571',
                'is_active' => true,
            ]
        );
        if (!$normalUser->hasRole($userRole)) {
            $normalUser->assignRole($userRole);
        }
    }
}
