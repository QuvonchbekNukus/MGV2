<?php
// Test cleanup functionality
require 'bootstrap/app.php';

$app = app();
$app['request'] = new \Illuminate\Http\Request();

// Set up auth context manually
$user = \App\Models\User::where('username', 'superadmin')->first();
auth()->login($user);

echo "=== Activity Log Test ===\n\n";

// Count total logs
$total = \App\Models\ActivityLog::count();
echo "Total logs: " . $total . "\n";

// Count logs older than 90 days
$old = \App\Models\ActivityLog::where('created_at', '<', now()->subDays(90))->count();
echo "Logs older than 90 days: " . $old . "\n";

// Count logs older than 1 day
$oneDay = \App\Models\ActivityLog::where('created_at', '<', now()->subDays(1))->count();
echo "Logs older than 1 day: " . $oneDay . "\n";

// Show sample logs
echo "\nRecent logs:\n";
\App\Models\ActivityLog::latest()->limit(5)->get()->each(function ($log) {
    echo $log->created_at . " - " . $log->action . " - " . $log->description . "\n";
});

// Delete old logs (test with 1 day)
echo "\n=== Deleting logs older than 1 day ===\n";
$deleted = \App\Models\ActivityLog::where('created_at', '<', now()->subDays(1))->delete();
echo "Deleted: " . $deleted . " logs\n";

// Count after delete
$afterDelete = \App\Models\ActivityLog::count();
echo "Total logs after delete: " . $afterDelete . "\n";
