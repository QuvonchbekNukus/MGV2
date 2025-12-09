<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
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
