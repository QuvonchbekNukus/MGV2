<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();

        // Activity stats
        $todayActivities = ActivityLog::whereDate('created_at', today())->count();
        $weekActivities = ActivityLog::whereBetween('created_at', [now()->subDays(7), now()])->count();
        $totalActivities = ActivityLog::count();

        // Recent activities (last 10)
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Activity by action (pie chart data)
        $activityByAction = ActivityLog::select('action', DB::raw('count(*) as count'))
            ->groupBy('action')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->action => $item->count];
            });

        // Last 7 days activity (line chart data)
        $last7DaysActivity = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $last7DaysActivity[] = [
                'date' => $date->format('d M'),
                'count' => ActivityLog::whereDate('created_at', $date)->count(),
            ];
        }

        // Most active users (top 5)
        $mostActiveUsers = ActivityLog::select('user_id', DB::raw('count(*) as activity_count'))
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderByDesc('activity_count')
            ->take(5)
            ->with('user')
            ->get();

        // Recent users
        $recentUsers = User::latest()->take(5)->get();

        // Action distribution for stats
        $createCount = ActivityLog::where('action', 'create')->count();
        $updateCount = ActivityLog::where('action', 'update')->count();
        $deleteCount = ActivityLog::where('action', 'delete')->count();
        $loginCount = ActivityLog::where('action', 'login')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalRoles',
            'totalPermissions',
            'todayActivities',
            'weekActivities',
            'totalActivities',
            'recentActivities',
            'activityByAction',
            'last7DaysActivity',
            'mostActiveUsers',
            'recentUsers',
            'createCount',
            'updateCount',
            'deleteCount',
            'loginCount'
        ));
    }
}
