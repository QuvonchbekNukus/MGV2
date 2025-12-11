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
        $groups = \App\Models\Group::all();
        return view('admin.users.create', compact('roles', 'groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'is_active' => 'boolean',
            // Qo'shimcha maydonlar
            'second_name' => 'nullable|string|max:255',
            'third_name' => 'nullable|string|max:255',
            'jinsi' => 'nullable|in:erkak,ayol',
            'rank' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'job_responsibility' => 'nullable|string',
            'is_married' => 'boolean',
            'degree' => 'nullable|string|max:255',
            'passport_seria' => 'nullable|string|max:10',
            'passport_code' => 'nullable|string|max:20',
            'height' => 'nullable|integer|min:0|max:300',
            'weight' => 'nullable|integer|min:0|max:300',
            'license_code' => 'nullable|string|max:50',
            'id_group' => 'nullable|exists:groups,id_group',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'password' => Hash::make($validated['password']),
            'is_active' => $request->has('is_active'),
            'second_name' => $validated['second_name'] ?? null,
            'third_name' => $validated['third_name'] ?? null,
            'jinsi' => $validated['jinsi'] ?? null,
            'rank' => $validated['rank'] ?? null,
            'job_title' => $validated['job_title'] ?? null,
            'job_responsibility' => $validated['job_responsibility'] ?? null,
            'is_married' => $request->has('is_married'),
            'degree' => $validated['degree'] ?? null,
            'passport_seria' => $validated['passport_seria'] ?? null,
            'passport_code' => $validated['passport_code'] ?? null,
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'license_code' => $validated['license_code'] ?? null,
            'id_group' => $validated['id_group'] ?? null,
        ]);

        $user->assignRole($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Foydalanuvchi muvaffaqiyatli yaratildi!');
    }

    public function show(User $user)
    {
        $user->load('roles', 'permissions', 'group', 'toys');

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
        $groups = \App\Models\Group::all();
        return view('admin.users.edit', compact('user', 'roles', 'groups'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'is_active' => 'boolean',
            // Qo'shimcha maydonlar
            'second_name' => 'nullable|string|max:255',
            'third_name' => 'nullable|string|max:255',
            'jinsi' => 'nullable|in:erkak,ayol',
            'rank' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'job_responsibility' => 'nullable|string',
            'is_married' => 'boolean',
            'degree' => 'nullable|string|max:255',
            'passport_seria' => 'nullable|string|max:10',
            'passport_code' => 'nullable|string|max:20',
            'height' => 'nullable|integer|min:0|max:300',
            'weight' => 'nullable|integer|min:0|max:300',
            'license_code' => 'nullable|string|max:50',
            'id_group' => 'nullable|exists:groups,id_group',
        ]);

        $userData = [
            'name' => $validated['name'],
            'username' => $validated['username'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_active' => $request->has('is_active'),
            'second_name' => $validated['second_name'] ?? null,
            'third_name' => $validated['third_name'] ?? null,
            'jinsi' => $validated['jinsi'] ?? null,
            'rank' => $validated['rank'] ?? null,
            'job_title' => $validated['job_title'] ?? null,
            'job_responsibility' => $validated['job_responsibility'] ?? null,
            'is_married' => $request->has('is_married'),
            'degree' => $validated['degree'] ?? null,
            'passport_seria' => $validated['passport_seria'] ?? null,
            'passport_code' => $validated['passport_code'] ?? null,
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'license_code' => $validated['license_code'] ?? null,
            'id_group' => $validated['id_group'] ?? null,
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

    /**
     * Search users for autocomplete
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('username', 'like', "%{$query}%")
            ->orWhere('second_name', 'like', "%{$query}%")
            ->orWhere('third_name', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'second_name' => $user->second_name,
                    'third_name' => $user->third_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'full_name' => trim($user->name . ' ' . ($user->second_name ?? '') . ' ' . ($user->third_name ?? '')),
                ];
            });

        return response()->json($users);
    }
}
