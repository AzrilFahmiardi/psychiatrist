<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PasienMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Ensure the authenticated user is a regular pasien (not admin or psikolog).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.psikologs.index')
                ->with('error', 'Anda login sebagai admin. Silakan akses panel admin.');
        }

        if ($user->role === 'psikolog') {
            return redirect()->route('home.psikolog')
                ->with('error', 'Anda login sebagai psikolog. Silakan akses dashboard psikolog.');
        }

        // Jika role NULL atau kosong, anggap sebagai pasien (untuk kompatibilitas data lama)
        // dan update role mereka
        if (empty($user->role)) {
            $user->role = 'pasien';
            $user->save();
        }

        // Pastikan role adalah 'pasien' (atau 'user' untuk backward compatibility)
        if ($user->role !== 'user' && $user->role !== 'pasien') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk pasien.');
        }

        return $next($request);
    }
}
