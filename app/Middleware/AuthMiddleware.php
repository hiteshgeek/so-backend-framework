<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * Authentication Middleware
 *
 * Protects routes requiring authentication
 */
class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Check if user is authenticated via session
        if (!auth()->check()) {
            // Try to authenticate via remember token
            if (!auth()->loginViaRememberToken()) {
                return redirect(url('/login'))
                    ->with('error', 'Please login to access this page.');
            }
        }

        // Attach authenticated user to request for controllers
        $request->set('user', auth()->user());

        return $next($request);
    }
}
