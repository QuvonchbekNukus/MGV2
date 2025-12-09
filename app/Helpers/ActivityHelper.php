<?php

namespace App\Helpers;

use Jenssegers\Agent\Agent;

class ActivityHelper
{
    /**
     * Get current IP address
     */
    public static function getIpAddress(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? request()->ip();
        }
    }

    /**
     * Detect device type
     */
    public static function detectDevice(): string
    {
        $userAgent = request()->userAgent();
        
        if (preg_match('/mobile/i', $userAgent)) {
            return 'Mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            return 'Tablet';
        } elseif (preg_match('/bot|crawl|slurp|spider/i', $userAgent)) {
            return 'Bot';
        }
        
        return 'Desktop';
    }

    /**
     * Detect browser
     */
    public static function detectBrowser(): string
    {
        $userAgent = request()->userAgent();

        if (preg_match('/Edge/i', $userAgent)) {
            return 'Edge';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            return 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            return 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            return 'Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            return 'Opera';
        }

        return 'Unknown';
    }

    /**
     * Detect platform/OS
     */
    public static function detectPlatform(): string
    {
        $userAgent = request()->userAgent();

        if (preg_match('/Windows/i', $userAgent)) {
            return 'Windows';
        } elseif (preg_match('/Mac/i', $userAgent)) {
            return 'MacOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            return 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            return 'Android';
        } elseif (preg_match('/iPhone|iPad/i', $userAgent)) {
            return 'iOS';
        }

        return 'Unknown';
    }

    /**
     * Get device icon
     */
    public static function getDeviceIcon(string $device): string
    {
        return match($device) {
            'Mobile' => 'fa-mobile-alt',
            'Tablet' => 'fa-tablet-alt',
            'Desktop' => 'fa-desktop',
            'Bot' => 'fa-robot',
            default => 'fa-question-circle',
        };
    }

    /**
     * Get browser icon
     */
    public static function getBrowserIcon(string $browser): string
    {
        return match($browser) {
            'Chrome' => 'fa-chrome',
            'Firefox' => 'fa-firefox',
            'Safari' => 'fa-safari',
            'Edge' => 'fa-edge',
            'Opera' => 'fa-opera',
            default => 'fa-globe',
        };
    }

    /**
     * Get platform icon
     */
    public static function getPlatformIcon(string $platform): string
    {
        return match($platform) {
            'Windows' => 'fa-windows',
            'MacOS' => 'fa-apple',
            'Linux' => 'fa-linux',
            'Android' => 'fa-android',
            'iOS' => 'fa-apple',
            default => 'fa-laptop',
        };
    }

    /**
     * Format changes for display
     */
    public static function formatChanges(array $properties): array
    {
        $formatted = [];
        
        if (isset($properties['old']) && isset($properties['new'])) {
            foreach ($properties['new'] as $key => $newValue) {
                $oldValue = $properties['old'][$key] ?? null;
                if ($oldValue != $newValue) {
                    $formatted[$key] = [
                        'old' => $oldValue,
                        'new' => $newValue,
                    ];
                }
            }
        }

        return $formatted;
    }
}

