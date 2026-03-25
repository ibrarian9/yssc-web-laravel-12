<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsMitra
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->role->isMitra()) {
            abort(403, 'Akses khusus Mitra.');
        }

        return $next($request);
    }
}
