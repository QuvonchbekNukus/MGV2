<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\ToyController;

// Asosiy sahifa - agar login bo'lsa dashboard, aks holda login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

// Standart dashboard (ishlatilmaydi, lekin Breeze uchun kerak)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin panel marshrutlari
Route::middleware(['auth', 'active.user'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:view-dashboard')
        ->name('dashboard');

    // Users boshqaruvi
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:view-users')
        ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->middleware('permission:create-users')
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->middleware('permission:create-users')
        ->name('users.store');

    Route::get('/users/{user}', [UserController::class, 'show'])
        ->middleware('auth')
        ->name('users.show');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('permission:edit-users')
        ->name('users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->middleware('permission:edit-users')
        ->name('users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:delete-users')
        ->name('users.destroy');

    // User activities bulk delete
    Route::post('/users/{user}/activities/delete-all', [UserController::class, 'deleteAllActivities'])
        ->middleware('permission:delete-activity-logs')
        ->name('users.activities.delete-all');

    // Roles boshqaruvi
    Route::get('/roles', [RoleController::class, 'index'])
        ->middleware('permission:view-roles')
        ->name('roles.index');

    Route::get('/roles/create', [RoleController::class, 'create'])
        ->middleware('permission:create-roles')
        ->name('roles.create');

    Route::post('/roles', [RoleController::class, 'store'])
        ->middleware('permission:create-roles')
        ->name('roles.store');

    Route::get('/roles/{role}', [RoleController::class, 'show'])
        ->middleware('permission:view-roles')
        ->name('roles.show');

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

    Route::get('/permissions/{permission}', [PermissionController::class, 'show'])
        ->middleware('permission:view-permissions')
        ->name('permissions.show');

    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])
        ->middleware('permission:assign-permissions')
        ->name('permissions.edit');

    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])
        ->middleware('permission:assign-permissions')
        ->name('permissions.update');

    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])
        ->middleware('permission:assign-permissions')
        ->name('permissions.destroy');

    // Activity Logs boshqaruvi
    Route::get('/activities', [ActivityLogController::class, 'index'])
        ->middleware('permission:view-activity-logs')
        ->name('activities.index');

    Route::get('/activities/{activity}', [ActivityLogController::class, 'show'])
        ->middleware('permission:view-activity-logs')
        ->name('activities.show');

    Route::delete('/activities/{activity}', [ActivityLogController::class, 'destroy'])
        ->middleware('permission:delete-activity-logs')
        ->name('activities.destroy');

    Route::post('/activities/cleanup', [ActivityLogController::class, 'cleanup'])
        ->middleware('permission:delete-activity-logs')
        ->name('activities.cleanup');

    // Groups boshqaruvi
    Route::resource('groups', GroupController::class)
        ->middleware('permission:view-groups');

    // Lessons boshqaruvi
    // Index - faqat view-lessons permission bo'lganda
    Route::get('/lessons', [LessonController::class, 'index'])
        ->middleware('permission:view-lessons')
        ->name('lessons.index');

    // Create - barcha userlar uchun (o'z guruhiga qo'shish) - {lesson} dan oldin bo'lishi kerak
    Route::get('/lessons/create', [LessonController::class, 'create'])
        ->name('lessons.create');

    Route::post('/lessons', [LessonController::class, 'store'])
        ->name('lessons.store');

    // Edit - barcha userlar uchun (o'zi qo'shgan lessonni tahrirlash) - {lesson} dan oldin bo'lishi kerak
    Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])
        ->name('lessons.edit');

    // Show va Update - faqat view-lessons permission bo'lganda
    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])
        ->middleware('permission:view-lessons')
        ->name('lessons.show');

    Route::put('/lessons/{lesson}', [LessonController::class, 'update'])
        ->name('lessons.update');

    // Delete - faqat edit-lessons permission bo'lganda
    Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy'])
        ->middleware('permission:edit-lessons')
        ->name('lessons.destroy');

    // Guruh Jurnallari - barcha userlar uchun (o'z guruhidagi darslarni ko'rish)
    Route::get('/group-journals/{group:id_group}', [LessonController::class, 'groupJournal'])
        ->name('group-journals.show');

    // Toys (Qurollar) boshqaruvi
    Route::resource('toys', ToyController::class)
        ->middleware('permission:view-toys');

    // Users search API for autocomplete
    Route::get('/users/search', [UserController::class, 'search'])
        ->middleware('permission:view-users')
        ->name('users.search');
});
