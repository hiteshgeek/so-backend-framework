<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Security\JWT;

/**
 * JWT Authentication Middleware
 *
 * Validates JWT tokens from Authorization header and attaches user to request.
 *
 * Token should be provided in Authorization header:
 *   Authorization: Bearer <token>
 *
 * After successful validation, decoded payload is attached to:
 *   $request->jwt - Full JWT payload
 *   $request->user_id - User ID from payload (if present)
 */
class JwtMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Extract token from Authorization header
        $token = $request->bearerToken();

        if (!$token) {
            return JsonResponse::error('Authorization token not provided', 401, [
                'error' => 'missing_token'
            ]);
        }

        try {
            // Create JWT instance from config
            $jwt = JWT::fromConfig();

            // Decode and verify token
            $payload = $jwt->decode($token);

            // Attach payload to request
            $request->jwt = $payload;

            // Extract user_id if present
            if (isset($payload['user_id'])) {
                $request->user_id = $payload['user_id'];
            }

            // Optionally load full user model
            if (isset($payload['user_id']) && class_exists('App\\Models\\User')) {
                $request->user = \App\Models\User::find($payload['user_id']);
            }

        } catch (\Exception $e) {
            return JsonResponse::error('Invalid or expired token', 401, [
                'error' => 'invalid_token',
                'message' => $e->getMessage()
            ]);
        }

        return $next($request);
    }
}
