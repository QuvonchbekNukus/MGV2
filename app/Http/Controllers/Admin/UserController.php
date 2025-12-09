<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'is_active' => 'boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'password' => Hash::make($validated['password']),
            'is_active' => $request->has('is_active'),
        ]);

        $user->assignRole($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Foydalanuvchi muvaffaqiyatli yaratildi!');
    }

    public function show(User $user)
    {
        $user->load('roles', 'permissions');

        // User ning barcha aktivliklari
        $activities = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        // Statistika
        $activityStats = [
            'total' => ActivityLog::where('user_id', $user->id)->count(),
            'today' => ActivityLog::where('user_id', $user->id)->whereDate('created_at', today())->count(),
            'week' => ActivityLog::where('user_id', $user->id)->whereBetween('created_at', [now()->subDays(7), now()])->count(),
            'create' => ActivityLog::where('user_id', $user->id)->where('action', 'create')->count(),
            'update' => ActivityLog::where('user_id', $user->id)->where('action', 'update')->count(),
            'delete' => ActivityLog::where('user_id', $user->id)->where('action', 'delete')->count(),
            'login' => ActivityLog::where('user_id', $user->id)->where('action', 'login')->count(),
        ];

        return view('admin.users.show', compact('user', 'activities', 'activityStats'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'is_active' => 'boolean',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);
        $user->syncRoles($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Foydalanuvchi muvaffaqiyatli yangilandi!');
    }

    public function destroy(User $user)
    {
        // O'z-o'zini o'chirish oldini olish
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Siz o\'z hisobingizni o\'chira olmaysiz!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Foydalanuvchi muvaffaqiyatli o\'chirildi!');
    }

    /**
     * Delete all activities for a specific user
     */
    public function deleteAllActivities(User $user)
    {
        $count = ActivityLog::where('user_id', $user->id)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$count} ta aktivlik o'chirildi!",
            'count' => $count
        ]);
    }
}
