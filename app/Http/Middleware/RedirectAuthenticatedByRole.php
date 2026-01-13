<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAuthenticatedByRole
{
    /**
     * Handle an incoming request.
     *
     * Redirect authenticated users to their role-specific dashboard
     * if they try to access routes meant for other roles.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.psikologs.index');
            }

            if ($user->role === 'psikolog') {
                return redirect()->route('home.psikolog');
            }
        }

        return $next($request);
    }
}
