<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class MenuBuilder
{
    public static function getAdminMenu(): array
    {
        return [
            [
                'title' => 'Dashboard',
                'icon' => 'fa-tachometer-alt',
                'route' => 'admin.dashboard',
                'permission' => 'view-dashboard',
            ],
            [
                'title' => 'Foydalanuvchilar',
                'icon' => 'fa-users',
                'permission' => 'view-users',
                'children' => [
                    [
                        'title' => 'Barcha Foydalanuvchilar',
                        'route' => 'admin.users.index',
                        'permission' => 'view-users',
                    ],
                    [
                        'title' => 'Yangi Foydalanuvchi',
                        'route' => 'admin.users.create',
                        'permission' => 'create-users',
                    ],
                ],
            ],
            [
                'title' => 'Rollar',
                'icon' => 'fa-user-tag',
                'route' => 'admin.roles.index',
                'permission' => 'view-roles',
            ],
            [
                'title' => 'Ruxsatlar',
                'icon' => 'fa-key',
                'route' => 'admin.permissions.index',
                'permission' => 'view-permissions',
            ],
        ];
    }

    public static function filterMenuByPermissions(array $menu): array
    {
        if (!Auth::check()) {
            return [];
        }

        return collect($menu)->filter(function ($item) {
            // Agar permission yo'q bo'lsa, yoki user ruxsatga ega bo'lsa
            if (!isset($item['permission']) || Auth::user()->can($item['permission'])) {
                // Agar children bo'lsa, ularni ham filter qilish
                if (isset($item['children'])) {
                    $item['children'] = self::filterMenuByPermissions($item['children']);
                }
                return true;
            }
            return false;
        })->values()->toArray();
    }
}

