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
        $user = auth()->user();
        $isAdmin = $user->can('view-users');

        // Basic stats - faqat admin uchun
        $totalUsers = $isAdmin ? User::count() : 0;
        $activeUsers = $isAdmin ? User::where('is_active', true)->count() : 0;
        $totalRoles = ($isAdmin && $user->can('view-roles')) ? Role::count() : 0;
        $totalPermissions = ($isAdmin && $user->can('view-permissions')) ? Permission::count() : 0;

        // Activity stats - user'ga tegishli
        $activityQuery = ActivityLog::where('user_id', $user->id);
        $todayActivities = (clone $activityQuery)->whereDate('created_at', today())->count();
        $weekActivities = (clone $activityQuery)->whereBetween('created_at', [now()->subDays(7), now()])->count();
        $totalActivities = (clone $activityQuery)->count();

        // Recent activities (last 10) - faqat user'ning o'z aktivliklari
        $recentActivities = ActivityLog::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        // Activity by action (pie chart data) - faqat user'ga tegishli
        $activityByAction = ActivityLog::where('user_id', $user->id)
            ->select('action', DB::raw('count(*) as count'))
            ->groupBy('action')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->action => $item->count];
            });

        // Last 7 days activity (line chart data) - faqat user'ga tegishli
        $last7DaysActivity = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $last7DaysActivity[] = [
                'date' => $date->format('d M'),
                'count' => ActivityLog::where('user_id', $user->id)->whereDate('created_at', $date)->count(),
            ];
        }

        // Most active users (top 5) - faqat admin uchun
        $mostActiveUsers = collect();
        if ($isAdmin) {
            $mostActiveUsers = ActivityLog::select('user_id', DB::raw('count(*) as activity_count'))
                ->whereNotNull('user_id')
                ->groupBy('user_id')
                ->orderByDesc('activity_count')
                ->take(5)
                ->with('user')
                ->get();
        }

        // Recent users - faqat admin uchun
        $recentUsers = $isAdmin ? User::latest()->take(5)->get() : collect();

        // Action distribution for stats - faqat user'ga tegishli
        $userActivityQuery = ActivityLog::where('user_id', $user->id);
        $createCount = (clone $userActivityQuery)->where('action', 'create')->count();
        $updateCount = (clone $userActivityQuery)->where('action', 'update')->count();
        $deleteCount = (clone $userActivityQuery)->where('action', 'delete')->count();
        $loginCount = (clone $userActivityQuery)->where('action', 'login')->count();

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
