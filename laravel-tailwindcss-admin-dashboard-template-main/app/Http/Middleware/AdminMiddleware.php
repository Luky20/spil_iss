<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login dan emailnya admin@spil.co.id
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            return abort(403, 'Anda tidak memiliki akses ke halaman ini.'); // Forbidden
        }

        return $next($request);
    }
}
