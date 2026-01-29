<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * CSRF Protection Middleware
 *
 * Validates CSRF tokens on state-changing requests
 */
class CsrfMiddleware implements MiddlewareInterface
{
    protected array $excludedRoutes = [
        '/api/*', // Exclude API routes from CSRF
    ];

    public function handle(Request $request, callable $next): Response
    {
        // Only check state-changing methods
        if (!in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            return $next($request);
        }

        // Check if route is excluded
        if ($this->shouldExclude($request)) {
            return $next($request);
        }

        $token = $request->input('_csrf_token');

        if (!$token || !csrf()->validateToken($token)) {
            return redirect()->back()
                ->with('error', 'CSRF token validation failed. Please try again.')
                ->withInput();
        }

        return $next($request);
    }

    /**
     * Check if request URI should be excluded from CSRF protection
     */
    protected function shouldExclude(Request $request): bool
    {
        foreach ($this->excludedRoutes as $pattern) {
            if (fnmatch($pattern, $request->uri())) {
                return true;
            }
        }
        return false;
    }
}
