<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\ActivityLog;
use App\Helpers\ActivityHelper;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Log login activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'login',
            'description' => auth()->user()->name . ' tizimga kirdi',
            'ip_address' => ActivityHelper::getIpAddress(),
            'user_agent' => request()->userAgent(),
            'device' => ActivityHelper::detectDevice(),
            'browser' => ActivityHelper::detectBrowser(),
            'platform' => ActivityHelper::detectPlatform(),
        ]);

        // Update last login (withoutEvents avtomatik trigger qilmaydi)
        auth()->user()->updateLastLogin();

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log logout activity
        if (auth()->check()) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'logout',
                'description' => auth()->user()->name . ' tizimdan chiqdi',
                'ip_address' => ActivityHelper::getIpAddress(),
                'user_agent' => request()->userAgent(),
                'device' => ActivityHelper::detectDevice(),
                'browser' => ActivityHelper::detectBrowser(),
                'platform' => ActivityHelper::detectPlatform(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
