<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by subject type
        if ($request->filled('subject_type')) {
            $query->where('subject_type', 'like', '%' . $request->subject_type . '%');
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $activities = $query->paginate(25);

        // Get filter data
        $users = \App\Models\User::select('id', 'name')->get();
        $actions = ['create', 'update', 'delete', 'view', 'login', 'logout'];

        return view('admin.activities.index', compact('activities', 'users', 'actions'));
    }

    /**
     * Show activity log details
     */
    public function show(ActivityLog $activity)
    {
        $activity->load('user', 'subject');
        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Delete old activity logs
     */
    public function destroy(ActivityLog $activity)
    {
        try {
            $activity->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Activity log o\'chirildi!'
                ]);
            }

            return redirect()->route('admin.activities.index')
                ->with('success', 'Activity log muvaffaqiyatli o\'chirildi!');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.activities.index')
                ->with('error', 'Xatolik yuz berdi!');
        }
    }

    /**
     * Bulk delete old logs
     */
    public function cleanup(Request $request)
    {
        try {
            $days = (int) $request->input('days', 30);

            // Agar days = 0 bo'lsa, BARCHA loglarni o'chirish
            if ($days === 0) {
                $count = ActivityLog::count();

                if ($count === 0) {
                    return redirect()->route('admin.activities.index')
                        ->with('info', 'O\'chirilsa bo\'ladigan log topilmadi.');
                }

                ActivityLog::truncate(); // Barcha loglarni o'chirish

                return redirect()->route('admin.activities.index')
                    ->with('success', "{$count} ta barcha log muvaffaqiyatli o'chirildi!");
            }

            // Muayyan kundan eski loglarni o'chirish
            $date = now()->subDays($days);
            $count = ActivityLog::where('created_at', '<', $date)->count();

            if ($count === 0) {
                return redirect()->route('admin.activities.index')
                    ->with('info', "Belgilangan {$days} kundan eski log topilmadi.");
            }

            ActivityLog::where('created_at', '<', $date)->delete();

            return redirect()->route('admin.activities.index')
                ->with('success', "{$count} ta eski log muvaffaqiyatli o'chirildi!");
        } catch (\Exception $e) {
            return redirect()->route('admin.activities.index')
                ->with('error', 'Loglarni o\'chirishda xatolik yuz berdi: ' . $e->getMessage());
        }
    }
}
