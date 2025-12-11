<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * AdminPermissionSeeder
 *
 * Bu seeder yangi ruxsatlar qo'shish va admin roliga biriktirish uchun ishlatiladi.
 * Yangi menyu yoki funksional qo'shganda, bu seeder orqali ruxsatlarni qo'shish mumkin.
 */
class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cache ni tozalash
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Yangi ruxsatlarni yaratish (agar mavjud bo'lmasa)
        $newPermissions = [
            // Bu yerda yangi ruxsatlarni qo'shing
            // Masalan:
            // 'view-new-feature',
            // 'create-new-feature',
            // 'edit-new-feature',
            // 'delete-new-feature',
        ];

        foreach ($newPermissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Admin roliga yangi ruxsatlarni biriktirish
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole && !empty($newPermissions)) {
            $adminRole->givePermissionTo($newPermissions);
        }

        $this->command->info('Admin roliga yangi ruxsatlar biriktirildi!');
    }
}

