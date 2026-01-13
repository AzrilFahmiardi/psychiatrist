<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * Redirect already authenticated users to their respective dashboards.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            return match($user->role) {
                'admin' => redirect()->route('admin.psikologs.index'),
                'psikolog' => redirect()->route('home.psikolog'),
                'user', 'pasien' => redirect()->route('home'),
                default => redirect()->route('home'),
            };
        }

        return $next($request);
    }
}
