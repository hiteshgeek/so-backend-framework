<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Security\Csrf;

/**
 * CSRF Protection Middleware
 *
 * Validates CSRF tokens on state-changing requests (POST, PUT, DELETE, PATCH).
 * Excluded routes can be configured in config/security.php
 *
 * Token can be provided via:
 *  - POST field: _token
 *  - Header: X-CSRF-TOKEN
 */
class CsrfMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Skip if CSRF protection is disabled
        if (!Csrf::isEnabled()) {
            return $next($request);
        }

        // Only check state-changing methods
        if (!in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            return $next($request);
        }

        // Check if route is excluded
        if (Csrf::isExcluded($request->uri())) {
            return $next($request);
        }

        // Get token from request (check POST field and header)
        $token = $request->input('_token') ?? $request->header('X-CSRF-TOKEN');

        // Verify token
        if (!$token || !Csrf::verify($token)) {
            return $this->failedResponse($request);
        }

        return $next($request);
    }

    /**
     * Create failed response based on request type
     *
     * @param Request $request
     * @return Response|JsonResponse
     */
    protected function failedResponse(Request $request)
    {
        // For API/JSON requests, return JSON response
        if ($request->expectsJson() || str_starts_with($request->uri(), 'api/')) {
            return JsonResponse::error('CSRF token mismatch', 419);
        }

        // For web requests, redirect back
        return redirect($request->header('Referer') ?? '/')
            ->with('error', 'CSRF token validation failed. Please refresh and try again.');
    }
}
