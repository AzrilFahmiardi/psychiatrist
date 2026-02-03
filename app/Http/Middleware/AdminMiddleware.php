<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Ensure the authenticated user has the 'admin' role.
     * Redirects other user types to their appropriate dashboards.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('nonPasien.loginpage')
                ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $user = Auth::user();

        if ($user->role === 'psikolog') {
            return redirect()->route('home.psikolog')
                ->with('error', 'Akses ditolak. Anda login sebagai psikolog.');
        }

        // User dengan role pasien, user, atau NULL dianggap sebagai pasien
        if ($user->role === 'user' || $user->role === 'pasien' || empty($user->role)) {
            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
