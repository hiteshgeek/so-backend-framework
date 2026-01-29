<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * CORS Middleware
 *
 * Handles Cross-Origin Resource Sharing (CORS) headers.
 * Allows API to be accessed from different domains.
 *
 * Configuration in config/cors.php
 */
class CorsMiddleware implements MiddlewareInterface
{
    /**
     * Handle request
     *
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function handle(Request $request, callable $next): Response
    {
        // Handle preflight OPTIONS request
        if ($request->method() === 'OPTIONS') {
            return $this->handlePreflightRequest($request);
        }

        // Continue with request
        $response = $next($request);

        // Add CORS headers to response
        return $this->addCorsHeaders($request, $response);
    }

    /**
     * Handle preflight OPTIONS request
     *
     * @param Request $request
     * @return Response
     */
    protected function handlePreflightRequest(Request $request): Response
    {
        $response = new Response('', 200);

        return $this->addCorsHeaders($request, $response);
    }

    /**
     * Add CORS headers to response
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    protected function addCorsHeaders(Request $request, Response $response): Response
    {
        $origin = $request->header('Origin');

        // Get allowed origins from config
        $allowedOrigins = $this->getAllowedOrigins();

        // Check if origin is allowed
        if ($this->isOriginAllowed($origin, $allowedOrigins)) {
            $response->header('Access-Control-Allow-Origin', $origin);
        } elseif (in_array('*', $allowedOrigins)) {
            $response->header('Access-Control-Allow-Origin', '*');
        }

        // Add other CORS headers
        $response->header('Access-Control-Allow-Methods', $this->getAllowedMethods());
        $response->header('Access-Control-Allow-Headers', $this->getAllowedHeaders());
        $response->header('Access-Control-Allow-Credentials', $this->allowCredentials() ? 'true' : 'false');
        $response->header('Access-Control-Max-Age', $this->getMaxAge());

        // Expose headers
        if ($exposedHeaders = $this->getExposedHeaders()) {
            $response->header('Access-Control-Expose-Headers', $exposedHeaders);
        }

        return $response;
    }

    /**
     * Check if origin is allowed
     *
     * @param string|null $origin
     * @param array $allowedOrigins
     * @return bool
     */
    protected function isOriginAllowed(?string $origin, array $allowedOrigins): bool
    {
        if (!$origin) {
            return false;
        }

        foreach ($allowedOrigins as $allowedOrigin) {
            if ($allowedOrigin === '*') {
                return true;
            }

            // Exact match
            if ($allowedOrigin === $origin) {
                return true;
            }

            // Wildcard match (e.g., *.example.com)
            if (str_contains($allowedOrigin, '*')) {
                $pattern = '#^' . str_replace('\*', '.*', preg_quote($allowedOrigin, '#')) . '$#';
                if (preg_match($pattern, $origin)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get allowed origins from config
     *
     * @return array
     */
    protected function getAllowedOrigins(): array
    {
        $origins = config('cors.allowed_origins', ['*']);

        if (is_string($origins)) {
            $origins = explode(',', $origins);
        }

        return array_map('trim', $origins);
    }

    /**
     * Get allowed methods
     *
     * @return string
     */
    protected function getAllowedMethods(): string
    {
        return config('cors.allowed_methods', 'GET,POST,PUT,DELETE,PATCH,OPTIONS');
    }

    /**
     * Get allowed headers
     *
     * @return string
     */
    protected function getAllowedHeaders(): string
    {
        return config('cors.allowed_headers', 'Content-Type,Authorization,X-CSRF-TOKEN,X-Requested-With');
    }

    /**
     * Get exposed headers
     *
     * @return string|null
     */
    protected function getExposedHeaders(): ?string
    {
        return config('cors.exposed_headers', null);
    }

    /**
     * Check if credentials are allowed
     *
     * @return bool
     */
    protected function allowCredentials(): bool
    {
        return config('cors.allow_credentials', false);
    }

    /**
     * Get max age for preflight cache
     *
     * @return string
     */
    protected function getMaxAge(): string
    {
        return config('cors.max_age', '86400'); // 24 hours
    }
}
