<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Jika belum login atau role tidak sesuai, tendang ke login masing-masing
        if (!auth()->check() || auth()->user()->role !== $role) {
            return redirect()->route('login.' . $role)->with('error', 'Akses ditolak! Silakan login.');
        }

        return $next($request);
    }
}