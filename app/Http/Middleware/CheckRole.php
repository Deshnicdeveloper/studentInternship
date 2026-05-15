<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * If the user is not authenticated, redirect to login.
     * If the user is authenticated but doesn't have the required role,
     * log them out and redirect to login with an informational message.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // User is logged in but doesn't have the required role.
        // Log them out and redirect to login so they can sign in with the correct account.
        // Save the intended URL so they are redirected back after re-authenticating
        $request->session()->put('url.intended', $request->fullUrl());

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $roleNames = implode(' or ', $roles);

        return redirect()->route('login')
            ->with('status', "You need to log in with a {$roleNames} account to access that page.");
    }
}
