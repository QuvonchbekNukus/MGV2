<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class ActivityLogPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Cache ni tozalash
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Yangi permissionlarni yaratish
        $newPermissions = [
            'view-activity-logs',
            'export-activity-logs',
            'delete-activity-logs',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',
        ];

        foreach ($newPermissions as $permissionName) {
            Permission::firstOrCreate(
                ['name' => $permissionName],
                ['guard_name' => 'web']
            );
        }

        // Super Admin ga barcha yangi ruxsatlarni berish
        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($newPermissions);
        }

        // Admin ga activity log ko'rish ruxsatini berish
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(['view-activity-logs', 'export-activity-logs']);
        }

        $this->command->info('Activity log permissions yaratildi va tayinlandi!');
    }
}
