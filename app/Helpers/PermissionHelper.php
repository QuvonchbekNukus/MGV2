<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    /**
     * Foydalanuvchiga biror ruxsat bormi?
     */
    public static function userCan(string $permission): bool
    {
        return Auth::check() && Auth::user()->can($permission);
    }

    /**
     * Foydalanuvchi biror rolga egami?
     */
    public static function userHasRole(string $role): bool
    {
        return Auth::check() && Auth::user()->hasRole($role);
    }

    /**
     * Foydalanuvchi super-adminmi?
     */
    public static function isSuperAdmin(): bool
    {
        return Auth::check() && Auth::user()->hasRole('super-admin');
    }

    /**
     * Menu elementini ko'rsatish kerakmi?
     */
    public static function canShowMenuItem(array $permissions): bool
    {
        if (empty($permissions)) {
            return true;
        }

        if (!Auth::check()) {
            return false;
        }

        foreach ($permissions as $permission) {
            if (Auth::user()->can($permission)) {
                return true;
            }
        }

        return false;
    }
}

