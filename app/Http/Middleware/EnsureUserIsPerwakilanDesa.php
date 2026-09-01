<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPerwakilanDesa
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isPerwakilanDesa()) {
            abort(403, 'Akses ditolak. Hanya perwakilan desa yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
