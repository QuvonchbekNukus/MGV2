<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;

class DummyActivityLogsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $actions = ['create', 'update', 'delete', 'view', 'login', 'logout'];
        $devices = ['Mobile', 'Desktop', 'Tablet'];
        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge'];
        $platforms = ['Windows', 'MacOS', 'Linux', 'Android', 'iOS'];
        
        // Oxirgi 7 kun uchun test data
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyCount = rand(5, 15); // Har kun 5-15 ta activity
            
            for ($j = 0; $j < $dailyCount; $j++) {
                $user = $users->random();
                $action = $actions[array_rand($actions)];
                $device = $devices[array_rand($devices)];
                $browser = $browsers[array_rand($browsers)];
                $platform = $platforms[array_rand($platforms)];
                
                ActivityLog::create([
                    'user_id' => $user->id,
                    'subject_type' => 'App\Models\User',
                    'subject_id' => $users->random()->id,
                    'action' => $action,
                    'description' => $this->getDescription($user->name, $action),
                    'properties' => $this->getProperties($action),
                    'ip_address' => $this->getRandomIp(),
                    'user_agent' => $this->getUserAgent($browser, $platform),
                    'device' => $device,
                    'browser' => $browser,
                    'platform' => $platform,
                    'created_at' => $date->setTime(rand(8, 20), rand(0, 59)),
                    'updated_at' => $date->setTime(rand(8, 20), rand(0, 59)),
                ]);
            }
        }
        
        $this->command->info('Dummy activity logs yaratildi!');
    }
    
    private function getDescription($userName, $action)
    {
        $descriptions = [
            'create' => "{$userName} yangi user yaratdi",
            'update' => "{$userName} user ma'lumotlarini yangiladi",
            'delete' => "{$userName} userni o'chirdi",
            'view' => "{$userName} ma'lumotlarni ko'rdi",
            'login' => "{$userName} tizimga kirdi",
            'logout' => "{$userName} tizimdan chiqdi",
        ];
        
        return $descriptions[$action] ?? "{$userName} amal bajardi";
    }
    
    private function getProperties($action)
    {
        if ($action === 'update') {
            return [
                'old' => ['name' => 'John Doe', 'is_active' => true],
                'new' => ['name' => 'John Smith', 'is_active' => false],
            ];
        } elseif ($action === 'create') {
            return [
                'new' => ['name' => 'New User', 'email' => 'newuser@example.com'],
            ];
        }
        
        return [];
    }
    
    private function getRandomIp()
    {
        return rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 255);
    }
    
    private function getUserAgent($browser, $platform)
    {
        $userAgents = [
            'Chrome-Windows' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Firefox-Linux' => 'Mozilla/5.0 (X11; Linux x86_64; rv:121.0) Gecko/20100101 Firefox/121.0',
            'Safari-MacOS' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 14_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Safari/605.1.15',
            'Edge-Windows' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Edg/120.0.0.0',
        ];
        
        $key = $browser . '-' . $platform;
        return $userAgents[$key] ?? $userAgents['Chrome-Windows'];
    }
}

