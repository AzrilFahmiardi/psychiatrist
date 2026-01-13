<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PsikologMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Ensure the authenticated user has the 'psikolog' role and has an associated psikolog record.
     * Redirects other user types to their appropriate dashboards.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('nonPasien.loginpage')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.psikologs.index')
                ->with('error', 'Akses ditolak. Anda login sebagai admin.');
        }

        if ($user->role === 'user' || $user->role === 'pasien') {
            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Halaman ini hanya untuk psikolog.');
        }

        if ($user->role !== 'psikolog') {
            abort(403, 'Akses ditolak. Hanya psikolog yang dapat mengakses halaman ini.');
        }

        if (!$user->psikolog) {
            abort(403, 'Data psikolog tidak ditemukan.');
        }

        return $next($request);
    }
}
