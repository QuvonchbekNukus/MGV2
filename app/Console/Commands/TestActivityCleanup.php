<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActivityLog;

class TestActivityCleanup extends Command
{
    protected $signature = 'test:cleanup {--days=90}';
    protected $description = 'Test activity log cleanup functionality';

    public function handle()
    {
        $days = $this->option('days');

        $this->info('=== Activity Log Cleanup Test ===');
        $this->line('');

        // Total logs
        $total = ActivityLog::count();
        $this->info("Total logs in database: {$total}");

        // Logs older than specified days
        $date = now()->subDays($days);
        $old = ActivityLog::where('created_at', '<', $date)->count();
        $this->info("Logs older than {$days} days: {$old}");

        // Sample logs
        $this->line('');
        $this->info('Recent 5 logs:');
        ActivityLog::latest()->limit(5)->get()->each(function ($log) {
            $this->line("  {$log->created_at} | {$log->action} | {$log->description}");
        });

        // Delete old logs
        $this->line('');
        if ($this->confirm("Delete logs older than {$days} days?")) {
            $deleted = ActivityLog::where('created_at', '<', $date)->delete();
            $this->info("Deleted: {$deleted} logs");

            $afterDelete = ActivityLog::count();
            $this->info("Total logs after delete: {$afterDelete}");
        } else {
            $this->info('Cancelled.');
        }
    }
}
