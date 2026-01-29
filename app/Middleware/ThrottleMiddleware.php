<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Security\RateLimiter;

/**
 * Throttle Middleware
 *
 * Rate limiting middleware to prevent API abuse.
 * Supports both per-IP (guest) and per-user (authenticated) throttling.
 *
 * Usage in routes:
 *   Router::middleware('throttle:60,1') // 60 requests per 1 minute
 *   Router::middleware('throttle:100,1') // 100 requests per 1 minute
 *
 * Parameters:
 *   - maxAttempts: Maximum number of requests allowed
 *   - decayMinutes: Time window in minutes (default: 1)
 */
class ThrottleMiddleware implements MiddlewareInterface
{
    /**
     * Rate limiter instance
     */
    protected RateLimiter $limiter;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->limiter = new RateLimiter(cache());
    }

    /**
     * Handle request
     *
     * @param Request $request
     * @param callable $next
     * @param string|null $maxAttempts Maximum attempts (default from config)
     * @param string|null $decayMinutes Decay time in minutes (default: 1)
     * @return Response
     */
    public function handle(Request $request, callable $next, ?string $maxAttempts = null, ?string $decayMinutes = null): Response
    {
        // Parse parameters or use defaults
        $maxAttempts = $maxAttempts ? (int) $maxAttempts : $this->getDefaultMaxAttempts();
        $decayMinutes = $decayMinutes ? (int) $decayMinutes : 1;

        // Generate rate limit key (user ID or IP address)
        $key = $this->resolveRequestSignature($request);

        // Check if rate limit exceeded
        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return $this->buildRateLimitExceededResponse($key, $maxAttempts, $request);
        }

        // Increment counter
        $this->limiter->hit($key, $decayMinutes);

        // Continue to next middleware
        $response = $next($request);

        // Add rate limit headers to response
        return $this->addRateLimitHeaders(
            $response,
            $maxAttempts,
            $this->limiter->retriesLeft($key, $maxAttempts),
            $this->limiter->availableIn($key)
        );
    }

    /**
     * Resolve request signature for rate limiting
     *
     * Uses user ID if authenticated, otherwise uses IP address
     *
     * @param Request $request
     * @return string
     */
    protected function resolveRequestSignature(Request $request): string
    {
        // Check if user is authenticated
        if (isset($request->user_id)) {
            return 'user:' . $request->user_id;
        }

        // Use IP address for guests
        return 'ip:' . $this->getClientIp($request);
    }

    /**
     * Get client IP address
     *
     * @param Request $request
     * @return string
     */
    protected function getClientIp(Request $request): string
    {
        // Check for forwarded IP (behind proxy/load balancer)
        if ($request->header('X-Forwarded-For')) {
            $ips = explode(',', $request->header('X-Forwarded-For'));
            return trim($ips[0]);
        }

        if ($request->header('X-Real-IP')) {
            return $request->header('X-Real-IP');
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Build rate limit exceeded response
     *
     * @param string $key
     * @param int $maxAttempts
     * @param Request $request
     * @return Response|JsonResponse
     */
    protected function buildRateLimitExceededResponse(string $key, int $maxAttempts, Request $request)
    {
        $retryAfter = $this->limiter->availableIn($key);

        // For API/JSON requests, return JSON response
        if ($request->expectsJson() || str_starts_with($request->uri(), 'api/')) {
            $response = JsonResponse::error('Too many requests. Please try again later.', 429);
        } else {
            // For web requests, return plain response
            $response = new Response('Too many requests. Please try again later.', 429);
        }

        // Add rate limit headers
        return $this->addRateLimitHeaders($response, $maxAttempts, 0, $retryAfter);
    }

    /**
     * Add rate limit headers to response
     *
     * @param Response|JsonResponse $response
     * @param int $maxAttempts
     * @param int $remainingAttempts
     * @param int|null $retryAfter
     * @return Response|JsonResponse
     */
    protected function addRateLimitHeaders($response, int $maxAttempts, int $remainingAttempts, ?int $retryAfter = null)
    {
        $response->header('X-RateLimit-Limit', (string) $maxAttempts);
        $response->header('X-RateLimit-Remaining', (string) max(0, $remainingAttempts));

        if ($retryAfter !== null && $retryAfter > 0) {
            $response->header('Retry-After', (string) $retryAfter);
            $response->header('X-RateLimit-Reset', (string) (time() + $retryAfter));
        }

        return $response;
    }

    /**
     * Get default max attempts from configuration
     *
     * @return int
     */
    protected function getDefaultMaxAttempts(): int
    {
        $default = config('security.rate_limit.default', '60,1');
        $parts = explode(',', $default);

        return (int) ($parts[0] ?? 60);
    }
}
