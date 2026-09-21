<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWargaLayananAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isWargaLayanan()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin sebagai warga layanan.');
        }

        return $next($request);
    }
}
