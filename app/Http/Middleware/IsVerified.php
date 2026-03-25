<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->hasVerifiedEmail()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Email belum diverifikasi.'], 403);
            }
            return redirect()->route('verification.notice')
                ->with('warning', 'Anda harus memverifikasi email terlebih dahulu.');
        }

        return $next($request);
    }
}
