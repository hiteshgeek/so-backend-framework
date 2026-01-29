<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;

/**
 * Authentication Middleware
 *
 * Protects routes requiring authentication.
 * Supports both session-based (web) and JWT-based (API) authentication.
 *
 * Usage:
 *   Router::middleware('auth')->get('/dashboard', ...);
 */
class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        $authenticated = false;

        // 1. Check session-based authentication (web)
        if (auth()->check()) {
            $authenticated = true;
            $request->set('user', auth()->user());
            $request->user_id = auth()->user()->id ?? null;
        }
        // Try remember token if session auth failed
        elseif (auth()->loginViaRememberToken()) {
            $authenticated = true;
            $request->set('user', auth()->user());
            $request->user_id = auth()->user()->id ?? null;
        }

        // 2. Check JWT authentication (API) if session auth failed
        if (!$authenticated && $this->checkJwtAuth($request)) {
            $authenticated = true;
        }

        // 3. Return error if not authenticated
        if (!$authenticated) {
            return $this->unauthenticatedResponse($request);
        }

        return $next($request);
    }

    /**
     * Check JWT authentication
     *
     * @param Request $request
     * @return bool
     */
    protected function checkJwtAuth(Request $request): bool
    {
        try {
            // Get JWT token from Authorization header
            $token = $request->bearerToken();

            if (!$token) {
                return false;
            }

            // Decode and verify token
            $jwt = \Core\Security\JWT::fromConfig();
            $payload = $jwt->decode($token);

            // Attach JWT payload to request
            $request->jwt = $payload;

            // Extract user_id if present
            if (isset($payload['user_id'])) {
                $request->user_id = $payload['user_id'];

                // Optionally load full user model
                // $request->set('user', User::find($payload['user_id']));
            }

            return true;
        } catch (\Exception $e) {
            // JWT verification failed
            return false;
        }
    }

    /**
     * Get unauthenticated response
     *
     * @param Request $request
     * @return Response|JsonResponse
     */
    protected function unauthenticatedResponse(Request $request)
    {
        // For API/JSON requests, return JSON response
        if ($request->expectsJson() || str_starts_with($request->uri(), 'api/')) {
            return JsonResponse::error('Unauthenticated', 401);
        }

        // For web requests, redirect to login
        $loginUrl = config('auth.login_url', '/login');

        return redirect(url($loginUrl))
            ->with('error', 'Please login to access this page.')
            ->with('intended', $request->uri());
    }
}
