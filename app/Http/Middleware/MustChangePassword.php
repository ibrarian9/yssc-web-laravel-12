<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustChangePassword
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->must_change_password) {
            // Don't redirect if already on the change-password page or logging out
            if ($request->routeIs('password.force-change') || $request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('password.force-change')
                ->with('warning', 'Anda harus mengganti password terlebih dahulu.');
        }

        return $next($request);
    }
}
