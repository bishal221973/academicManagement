<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEmailVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Allow access to login, register, verification routes, etc.
        $excludedRoutes = [
            'login',
            'root',
            'register',
            'logout',
            'password.request',
            'password.email',
            'password.reset',
            'password.update',
            'verification.notice',
            'verification.verify',
            'verification.send',
        ];

        if (
            $user &&
            !$user->email_verified_at &&
            !$request->routeIs($excludedRoutes)
        ) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
