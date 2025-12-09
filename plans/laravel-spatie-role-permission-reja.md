# Laravel 12 + Spatie Role-Permission Admin Panel Loyihasi

## 📋 Loyiha Tavsifi
Bu loyihada Laravel 12 framework va Spatie Laravel-Permission paketi yordamida role va permission asosida ishlaydigon admin panel yaratamiz. Foydalanuvchilar o'z rollariga qarab menu va amallarni ko'rish/bajarish huquqiga ega bo'ladilar.

---

## 🚀 1-Bosqich: O'rnatish va Sozlash

### 1.1 Spatie Laravel-Permission Paketini O'rnatish

```bash
composer require spatie/laravel-permission
```

### 1.2 Config Faylini Publish Qilish

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### 1.3 Migration Fayllarini Yaratish

```bash
php artisan migrate
```

Bu quyidagi jadvallarni yaratadi:
- `roles` - rollar jadvali
- `permissions` - ruxsatlar jadvali
- `model_has_permissions` - model va ruxsatlar bog'lanishi
- `model_has_roles` - model va rollar bog'lanishi
- `role_has_permissions` - rol va ruxsatlar bog'lanishi

---

## 🗄️ 2-Bosqich: Ma'lumotlar Bazasi Strukturasi

### 2.1 Qo'shimcha Migration - Users Jadvaliga Ustunlar Qo'shish

```bash
php artisan make:migration add_additional_fields_to_users_table --table=users
```

**Migration kodi:**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'is_active', 'last_login_at']);
        });
    }
};
```

---

## 📦 3-Bosqich: Model Sozlamalari

### 3.1 User Model

**Fayl: `app/Models/User.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Foydalanuvchi faolmi?
    public function isActive(): bool
    {
        return $this->is_active;
    }

    // Oxirgi kirish vaqtini yangilash
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }
}
```

---

## 🌱 4-Bosqich: Seeder - Dastlabki Ma'lumotlar

### 4.1 Role va Permission Seeder

```bash
php artisan make:seeder RolePermissionSeeder
```

**Fayl: `database/seeders/RolePermissionSeeder.php`**

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Cache ni tozalash
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissionlarni yaratish
        $permissions = [
            // User permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // Role permissions
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            
            // Permission permissions
            'view-permissions',
            'assign-permissions',
            
            // Dashboard
            'view-dashboard',
            
            // Settings
            'view-settings',
            'edit-settings',
            
            // Reports
            'view-reports',
            'export-reports',
            
            // Content Management
            'view-posts',
            'create-posts',
            'edit-posts',
            'delete-posts',
            'publish-posts',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Super Admin roli yaratish (barcha ruxsatlarga ega)
        $superAdminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin roli
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            'view-dashboard',
            'view-users',
            'create-users',
            'edit-users',
            'view-roles',
            'view-permissions',
            'view-settings',
            'view-reports',
            'export-reports',
            'view-posts',
            'create-posts',
            'edit-posts',
            'publish-posts',
        ]);

        // Moderator roli
        $moderatorRole = Role::create(['name' => 'moderator', 'guard_name' => 'web']);
        $moderatorRole->givePermissionTo([
            'view-dashboard',
            'view-users',
            'view-posts',
            'edit-posts',
            'view-reports',
        ]);

        // Editor roli
        $editorRole = Role::create(['name' => 'editor', 'guard_name' => 'web']);
        $editorRole->givePermissionTo([
            'view-dashboard',
            'view-posts',
            'create-posts',
            'edit-posts',
        ]);

        // User roli (oddiy foydalanuvchi)
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);
        $userRole->givePermissionTo([
            'view-dashboard',
        ]);

        // Test foydalanuvchilarni yaratish
        
        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234567',
            'is_active' => true,
        ]);
        $superAdmin->assignRole($superAdminRole);

        // Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234568',
            'is_active' => true,
        ]);
        $admin->assignRole($adminRole);

        // Moderator
        $moderator = User::create([
            'name' => 'Moderator User',
            'email' => 'moderator@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234569',
            'is_active' => true,
        ]);
        $moderator->assignRole($moderatorRole);

        // Editor
        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234570',
            'is_active' => true,
        ]);
        $editor->assignRole($editorRole);

        // Oddiy User
        $normalUser = User::create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone' => '+998901234571',
            'is_active' => true,
        ]);
        $normalUser->assignRole($userRole);
    }
}
```

### 4.2 DatabaseSeeder ni Yangilash

**Fayl: `database/seeders/DatabaseSeeder.php`**

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);
    }
}
```

### 4.3 Seederni Ishga Tushirish

```bash
php artisan db:seed
```

---

## 🔧 5-Bosqich: Middleware Yaratish

### 5.1 Permission Middleware

```bash
php artisan make:middleware CheckPermission
```

**Fayl: `app/Http/Middleware/CheckPermission.php`**

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Iltimos tizimga kiring');
        }

        if (!$request->user()->can($permission)) {
            abort(403, 'Sizda bu sahifaga kirish uchun ruxsat yo\'q.');
        }

        return $next($request);
    }
}
```

### 5.2 Role Middleware

```bash
php artisan make:middleware CheckRole
```

**Fayl: `app/Http/Middleware/CheckRole.php`**

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Iltimos tizimga kiring');
        }

        if (!$request->user()->hasRole($role)) {
            abort(403, 'Sizda bu sahifaga kirish uchun rol ruxsati yo\'q.');
        }

        return $next($request);
    }
}
```

### 5.3 Active User Middleware

```bash
php artisan make:middleware EnsureUserIsActive
```

**Fayl: `app/Http/Middleware/EnsureUserIsActive.php`**

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->isActive()) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Sizning hisobingiz faol emas. Administrator bilan bog\'laning.');
        }

        return $next($request);
    }
}
```

### 5.4 Middleware ni Ro'yxatdan O'tkazish

**Fayl: `bootstrap/app.php`**

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\EnsureUserIsActive;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'permission' => CheckPermission::class,
            'role' => CheckRole::class,
            'active.user' => EnsureUserIsActive::class,
        ]);
        
        // Web middleware guruhiga active.user ni qo'shish
        $middleware->web(append: [
            EnsureUserIsActive::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

---

## 🎮 6-Bosqich: Controller Yaratish

### 6.1 Dashboard Controller

```bash
php artisan make:controller Admin/DashboardController
```

**Fayl: `app/Http/Controllers/Admin/DashboardController.php`**

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'totalRoles' => Role::count(),
            'totalPermissions' => Permission::count(),
            'recentUsers' => User::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
```

### 6.2 User Controller

```bash
php artisan make:controller Admin/UserController --resource
```

**Fayl: `app/Http/Controllers/Admin/UserController.php`**

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        return view('admin.users.show', compact('user'));
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
}
```

### 6.3 Role Controller

```bash
php artisan make:controller Admin/RoleController --resource
```

**Fayl: `app/Http/Controllers/Admin/RoleController.php`**

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('-', $permission->name)[1] ?? 'other';
        });
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);
        
        if (!empty($validated['permissions'])) {
            $role->givePermissionTo($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol muvaffaqiyatli yaratildi!');
    }

    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('-', $permission->name)[1] ?? 'other';
        });
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol muvaffaqiyatli yangilandi!');
    }

    public function destroy(Role $role)
    {
        // Super admin rolini o'chirish oldini olish
        if ($role->name === 'super-admin') {
            return back()->with('error', 'Super Admin rolini o\'chirish mumkin emas!');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol muvaffaqiyatli o\'chirildi!');
    }
}
```

### 6.4 Permission Controller

```bash
php artisan make:controller Admin/PermissionController --resource
```

**Fayl: `app/Http/Controllers/Admin/PermissionController.php`**

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('-', $permission->name)[1] ?? 'other';
        });
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create(['name' => $validated['name'], 'guard_name' => 'web']);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Ruxsat muvaffaqiyatli yaratildi!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Ruxsat muvaffaqiyatli o\'chirildi!');
    }
}
```

---

## 🛣️ 7-Bosqich: Routes (Marshrutlar)

**Fayl: `routes/web.php`**

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes(); // Agar Laravel Breeze/Jetstream ishlatmasangiz

// Admin panel marshrutlari
Route::middleware(['auth', 'active.user'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:view-dashboard')
        ->name('dashboard');

    // Users boshqaruvi
    Route::middleware('permission:view-users')->group(function () {
        Route::resource('users', UserController::class)->except(['index', 'create', 'store']);
    });
    
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:view-users')
        ->name('users.index');
    
    Route::get('/users/create', [UserController::class, 'create'])
        ->middleware('permission:create-users')
        ->name('users.create');
    
    Route::post('/users', [UserController::class, 'store'])
        ->middleware('permission:create-users')
        ->name('users.store');
    
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('permission:edit-users')
        ->name('users.edit');
    
    Route::put('/users/{user}', [UserController::class, 'update'])
        ->middleware('permission:edit-users')
        ->name('users.update');
    
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:delete-users')
        ->name('users.destroy');

    // Roles boshqaruvi
    Route::middleware('permission:view-roles')->group(function () {
        Route::resource('roles', RoleController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    });
    
    Route::get('/roles/create', [RoleController::class, 'create'])
        ->middleware('permission:create-roles')
        ->name('roles.create');
    
    Route::post('/roles', [RoleController::class, 'store'])
        ->middleware('permission:create-roles')
        ->name('roles.store');
    
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])
        ->middleware('permission:edit-roles')
        ->name('roles.edit');
    
    Route::put('/roles/{role}', [RoleController::class, 'update'])
        ->middleware('permission:edit-roles')
        ->name('roles.update');
    
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])
        ->middleware('permission:delete-roles')
        ->name('roles.destroy');

    // Permissions boshqaruvi
    Route::get('/permissions', [PermissionController::class, 'index'])
        ->middleware('permission:view-permissions')
        ->name('permissions.index');
    
    Route::get('/permissions/create', [PermissionController::class, 'create'])
        ->middleware('permission:view-permissions')
        ->name('permissions.create');
    
    Route::post('/permissions', [PermissionController::class, 'store'])
        ->middleware('permission:assign-permissions')
        ->name('permissions.store');
    
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])
        ->middleware('permission:assign-permissions')
        ->name('permissions.destroy');
});
```

---

## 🎨 8-Bosqich: View (Ko'rinish) Fayllar

### 8.1 Layout Fayl

**Fayl: `resources/views/layouts/admin.blade.php`**

```blade
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
            </div>
            
            <nav class="mt-4">
                <!-- Dashboard -->
                @can('view-dashboard')
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                @endcan

                <!-- Users Menu -->
                @can('view-users')
                <div class="mt-2">
                    <div class="px-4 py-2 text-gray-400 text-xs uppercase">Foydalanuvchilar</div>
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-users mr-3"></i>
                        Barcha Foydalanuvchilar
                    </a>
                    @can('create-users')
                    <a href="{{ route('admin.users.create') }}" 
                       class="flex items-center px-4 py-3 hover:bg-gray-700">
                        <i class="fas fa-user-plus mr-3"></i>
                        Yangi Foydalanuvchi
                    </a>
                    @endcan
                </div>
                @endcan

                <!-- Roles & Permissions -->
                @can('view-roles')
                <div class="mt-2">
                    <div class="px-4 py-2 text-gray-400 text-xs uppercase">Rollar va Ruxsatlar</div>
                    <a href="{{ route('admin.roles.index') }}" 
                       class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.roles.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-user-tag mr-3"></i>
                        Rollar
                    </a>
                    @can('view-permissions')
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="flex items-center px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.permissions.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-key mr-3"></i>
                        Ruxsatlar
                    </a>
                    @endcan
                </div>
                @endcan

                <!-- Settings -->
                @can('view-settings')
                <div class="mt-2">
                    <div class="px-4 py-2 text-gray-400 text-xs uppercase">Sozlamalar</div>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-700">
                        <i class="fas fa-cog mr-3"></i>
                        Umumiy Sozlamalar
                    </a>
                </div>
                @endcan

                <!-- Reports -->
                @can('view-reports')
                <div class="mt-2">
                    <div class="px-4 py-2 text-gray-400 text-xs uppercase">Hisobotlar</div>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-700">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Statistika
                    </a>
                </div>
                @endcan
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        @yield('page-title', 'Dashboard')
                    </h2>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                        <span class="text-sm text-gray-500">
                            ({{ auth()->user()->roles->pluck('name')->join(', ') }})
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt"></i> Chiqish
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                
                <!-- Alerts -->
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
                @endif

                @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
```

### 8.2 Dashboard View

**Fayl: `resources/views/admin/dashboard.blade.php`**

```blade
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    
    <!-- Total Users Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Jami Foydalanuvchilar</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-users text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Active Users Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Faol Foydalanuvchilar</p>
                <p class="text-3xl font-bold text-gray-800">{{ $activeUsers }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-user-check text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Roles Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Jami Rollar</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalRoles }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <i class="fas fa-user-tag text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Permissions Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Jami Ruxsatlar</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPermissions }}</p>
            </div>
            <div class="bg-yellow-100 rounded-full p-3">
                <i class="fas fa-key text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Oxirgi Foydalanuvchilar</h3>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ism</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rollar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Holat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qo'shilgan</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($recentUsers as $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @foreach($user->roles as $role)
                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($user->is_active)
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Faol</span>
                    @else
                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Nofaol</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $user->created_at->format('d.m.Y') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
```

### 8.3 Users Index View

**Fayl: `resources/views/admin/users/index.blade.php`**

```blade
@extends('layouts.admin')

@section('title', 'Foydalanuvchilar')
@section('page-title', 'Foydalanuvchilar')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <h3 class="text-xl font-semibold">Barcha Foydalanuvchilar</h3>
    @can('create-users')
    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i>Yangi Foydalanuvchi
    </a>
    @endcan
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ism</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telefon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rollar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Holat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amallar</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->phone ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @foreach($user->roles as $role)
                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($user->is_active)
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Faol</span>
                    @else
                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Nofaol</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 mr-2">
                        <i class="fas fa-eye"></i>
                    </a>
                    @can('edit-users')
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can('delete-users')
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" 
                                onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    Foydalanuvchilar topilmadi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="px-6 py-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
```

### 8.4 Users Create/Edit View

**Fayl: `resources/views/admin/users/create.blade.php`**

```blade
@extends('layouts.admin')

@section('title', 'Yangi Foydalanuvchi')
@section('page-title', 'Yangi Foydalanuvchi Qo\'shish')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ism *</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Telefon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Manzil</label>
                <textarea name="address" rows="3" 
                          class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">{{ old('address') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Parol *</label>
                <input type="password" name="password" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Parolni Tasdiqlash *</label>
                <input type="password" name="password_confirmation" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Rollar *</label>
                <div class="space-y-2">
                    @foreach($roles as $role)
                    <label class="flex items-center">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                               class="mr-2" {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                        <span>{{ $role->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="mr-2" 
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="text-gray-700">Faol</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>Orqaga
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Saqlash
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
```

**Fayl: `resources/views/admin/users/edit.blade.php`**

```blade
@extends('layouts.admin')

@section('title', 'Foydalanuvchini Tahrirlash')
@section('page-title', 'Foydalanuvchini Tahrirlash')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ism *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Telefon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Manzil</label>
                <textarea name="address" rows="3" 
                          class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Yangi Parol (o'zgartirish uchun)</label>
                <input type="password" name="password" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Parolni Tasdiqlash</label>
                <input type="password" name="password_confirmation" 
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Rollar *</label>
                <div class="space-y-2">
                    @foreach($roles as $role)
                    <label class="flex items-center">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                               class="mr-2" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                        <span>{{ $role->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="mr-2" 
                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <span class="text-gray-700">Faol</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>Orqaga
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Yangilash
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
```

---

## 🔐 9-Bosqich: Blade Directives (Ko'rinishlarda Foydalanish)

### Rolni Tekshirish

```blade
@role('super-admin')
    <!-- Faqat super-admin ko'radi -->
    <p>Super Admin Content</p>
@endrole

@hasanyrole('admin|moderator')
    <!-- Admin yoki moderator ko'radi -->
    <p>Admin yoki Moderator Content</p>
@endhasanyrole

@hasallroles('admin|moderator')
    <!-- Ikkala rol ham bo'lsa ko'rsatadi -->
    <p>Admin VA Moderator Content</p>
@endhasallroles
```

### Ruxsatni Tekshirish

```blade
@can('edit-users')
    <a href="{{ route('admin.users.edit', $user) }}">Tahrirlash</a>
@endcan

@cannot('delete-users')
    <p class="text-gray-500">Siz foydalanuvchilarni o'chira olmaysiz</p>
@endcannot

@canany(['edit-users', 'delete-users'])
    <div>Tahrirlash yoki o'chirish mumkin</div>
@endcanany
```

---

## ⚙️ 10-Bosqich: Helper Functions (Yordamchi Funksiyalar)

### Fayl: `app/Helpers/PermissionHelper.php`

```php
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
```

### Helper ni Autoload Qilish

**Fayl: `composer.json`**

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    },
    "files": [
        "app/Helpers/PermissionHelper.php"
    ]
},
```

Keyin:

```bash
composer dump-autoload
```

---

## 📝 11-Bosqich: Config Sozlamalari

### Fayl: `config/permission.php`

```php
<?php

return [

    'models' => [
        'permission' => Spatie\Permission\Models\Permission::class,
        'role' => Spatie\Permission\Models\Role::class,
    ],

    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        'role_pivot_key' => null,
        'permission_pivot_key' => null,
        'model_morph_key' => 'model_id',
        'team_foreign_key' => 'team_id',
    ],

    'register_permission_check_method' => true,
    'register_octane_reset_listener' => false,
    'teams' => false,
    'use_passport_client_credentials' => false,
    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,
    'enable_wildcard_permission' => false,
    'cache' => [
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],
];
```

---

## 🧪 12-Bosqich: Testing (Sinov)

### Permission Test

**Fayl: `tests/Feature/PermissionTest.php`**

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_permissions()
    {
        $user = User::factory()->create();
        $permission = Permission::create(['name' => 'test-permission']);
        
        $user->givePermissionTo($permission);
        
        $this->assertTrue($user->hasPermissionTo('test-permission'));
    }

    public function test_user_can_have_roles()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-role']);
        
        $user->assignRole($role);
        
        $this->assertTrue($user->hasRole('test-role'));
    }

    public function test_role_can_have_permissions()
    {
        $role = Role::create(['name' => 'test-role']);
        $permission = Permission::create(['name' => 'test-permission']);
        
        $role->givePermissionTo($permission);
        
        $this->assertTrue($role->hasPermissionTo('test-permission'));
    }
}
```

---

## 📚 13-Bosqich: Qo'shimcha Xususiyatlar

### 13.1 Menu Builder (Dinamik Menu)

**Fayl: `app/Services/MenuBuilder.php`**

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class MenuBuilder
{
    public static function getAdminMenu(): array
    {
        return [
            [
                'title' => 'Dashboard',
                'icon' => 'fa-tachometer-alt',
                'route' => 'admin.dashboard',
                'permission' => 'view-dashboard',
            ],
            [
                'title' => 'Foydalanuvchilar',
                'icon' => 'fa-users',
                'permission' => 'view-users',
                'children' => [
                    [
                        'title' => 'Barcha Foydalanuvchilar',
                        'route' => 'admin.users.index',
                        'permission' => 'view-users',
                    ],
                    [
                        'title' => 'Yangi Foydalanuvchi',
                        'route' => 'admin.users.create',
                        'permission' => 'create-users',
                    ],
                ],
            ],
            [
                'title' => 'Rollar',
                'icon' => 'fa-user-tag',
                'route' => 'admin.roles.index',
                'permission' => 'view-roles',
            ],
            [
                'title' => 'Ruxsatlar',
                'icon' => 'fa-key',
                'route' => 'admin.permissions.index',
                'permission' => 'view-permissions',
            ],
            [
                'title' => 'Sozlamalar',
                'icon' => 'fa-cog',
                'route' => 'admin.settings',
                'permission' => 'view-settings',
            ],
        ];
    }

    public static function filterMenuByPermissions(array $menu): array
    {
        if (!Auth::check()) {
            return [];
        }

        return collect($menu)->filter(function ($item) {
            // Agar permission yo'q bo'lsa, yoki user ruxsatga ega bo'lsa
            if (!isset($item['permission']) || Auth::user()->can($item['permission'])) {
                // Agar children bo'lsa, ularni ham filter qilish
                if (isset($item['children'])) {
                    $item['children'] = self::filterMenuByPermissions($item['children']);
                }
                return true;
            }
            return false;
        })->values()->toArray();
    }
}
```

---

## 🚀 14-Bosqich: Ishga Tushirish

```bash
# Ma'lumotlar bazasini tozalash va qayta yaratish
php artisan migrate:fresh

# Seederni ishga tushirish
php artisan db:seed

# Cache ni tozalash
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Permission cache ni tozalash
php artisan permission:cache-reset

# Serverni ishga tushirish
php artisan serve
```

## 🔑 Kirish Ma'lumotlari

Loyihani ishga tushirganingizdan keyin quyidagi hisoblar bilan kirish mumkin:

- **Super Admin**: superadmin@example.com / password
- **Admin**: admin@example.com / password
- **Moderator**: moderator@example.com / password
- **Editor**: editor@example.com / password
- **User**: user@example.com / password

---

## 📖 Foydali Metodlar

### User Model

```php
// Rol berish
$user->assignRole('admin');
$user->assignRole(['editor', 'moderator']);

// Rol tekshirish
$user->hasRole('admin');
$user->hasAnyRole(['admin', 'moderator']);
$user->hasAllRoles(['admin', 'moderator']);

// Rol olib tashlash
$user->removeRole('admin');
$user->syncRoles(['editor', 'moderator']);

// Ruxsat berish
$user->givePermissionTo('edit-posts');

// Ruxsat tekshirish
$user->can('edit-posts');
$user->hasPermissionTo('edit-posts');

// Ruxsatni olib tashlash
$user->revokePermissionTo('edit-posts');
```

### Role Model

```php
// Rolga ruxsat berish
$role->givePermissionTo('edit-posts');
$role->givePermissionTo(['edit-posts', 'delete-posts']);

// Ruxsatlarni sinxronlashtirish
$role->syncPermissions(['edit-posts', 'delete-posts']);

// Ruxsatni olib tashlash
$role->revokePermissionTo('edit-posts');
```

---

## ⚡ Optimizatsiya

### Cache Sozlamalari

```php
// Config faylda (config/permission.php)
'cache' => [
    'expiration_time' => \DateInterval::createFromDateString('24 hours'),
    'key' => 'spatie.permission.cache',
    'store' => 'default',
],
```

### Cache ni Yangilash

```bash
php artisan permission:cache-reset
```

---

## 🎯 Xulosa

Bu loyiha quyidagi funksiyalarni amalga oshiradi:

✅ Laravel 12 + Spatie Permission integratsiyasi
✅ Role va Permission asosida autentifikatsiya
✅ Dinamik menu sistema (ruxsatlarga qarab)
✅ Foydalanuvchilar CRUD operatsiyalari
✅ Rollar va Ruxsatlar boshqaruvi
✅ Middleware orqali sahifalarni himoyalash
✅ Blade directives orqali UI elementlarini boshqarish
✅ Seeder va test ma'lumotlari
✅ Modern va responsive admin panel
✅ User holati (active/inactive) boshqaruvi

---

**Muallif**: Quvonch  
**Sana**: {{ date('Y-m-d') }}  
**Versiya**: 1.0

