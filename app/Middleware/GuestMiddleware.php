<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * Guest Middleware
 *
 * Redirects authenticated users away from guest-only pages (login, register)
 */
class GuestMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        if (auth()->check()) {
            return redirect(url('/dashboard'));
        }

        return $next($request);
    }
}
