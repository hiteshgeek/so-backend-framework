<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * API Version Detection Middleware
 *
 * Detects API version from URL or Accept header and attaches it to the request.
 *
 * Version Detection Strategy:
 * 1. URL-based (primary): /api/v1/users, /api/v2/products
 * 2. Header-based (fallback): Accept: application/vnd.api.v1+json
 * 3. Default version if none specified
 *
 * Detected version is attached to:
 *   $request->api_version - Version string (e.g., "v1", "v2")
 *   $request->api_version_number - Version number (e.g., 1, 2)
 *
 * Configuration:
 *   - config('api.default_version') - Default version (default: "v1")
 *   - config('api.supported_versions') - Array of supported versions
 *   - config('api.deprecated_versions') - Array of deprecated versions
 */
class ApiVersionMiddleware implements MiddlewareInterface
{
    /**
     * Handle incoming request
     */
    public function handle(Request $request, callable $next): Response
    {
        // 1. Try to extract version from URL path
        $version = $this->extractVersionFromPath($request->uri());

        // 2. If not found in URL, try Accept header
        if ($version === null) {
            $version = $this->extractVersionFromHeader($request->header('Accept'));
        }

        // 3. Fall back to default version
        if ($version === null) {
            $version = $this->getDefaultVersion();
        }

        // Validate version
        if (!$this->isVersionSupported($version)) {
            $version = $this->getDefaultVersion();
        }

        // Attach version to request
        $request->api_version = $version;
        $request->api_version_number = $this->extractVersionNumber($version);

        // Check if version is deprecated
        if ($this->isVersionDeprecated($version)) {
            // Add deprecation warning header
            $response = $next($request);
            if ($response instanceof Response) {
                $response->header('X-API-Version-Deprecated', 'true');
                $response->header(
                    'X-API-Deprecation-Info',
                    "API version {$version} is deprecated. Please migrate to a newer version."
                );
            }
            return $response;
        }

        return $next($request);
    }

    /**
     * Extract version from URL path
     *
     * Matches patterns like:
     * - /api/v1/users
     * - /api/v2/products
     * - /v1/users
     *
     * @param string $path Request path
     * @return string|null Version string (e.g., "v1") or null
     */
    protected function extractVersionFromPath(string $path): ?string
    {
        // Match /v1/, /v2/, etc. in the path
        if (preg_match('#/v(\d+)(?:/|$)#', $path, $matches)) {
            return 'v' . $matches[1];
        }

        return null;
    }

    /**
     * Extract version from Accept header
     *
     * Matches patterns like:
     * - application/vnd.api.v1+json
     * - application/vnd.api.v2+json
     * - application/vnd.myapp.v1+json
     *
     * @param string|null $acceptHeader Accept header value
     * @return string|null Version string (e.g., "v1") or null
     */
    protected function extractVersionFromHeader(?string $acceptHeader): ?string
    {
        if ($acceptHeader === null) {
            return null;
        }

        // Match version in Accept header (vnd.*.vN+json or vnd.*.vN)
        if (preg_match('#\.v(\d+)(?:\+|\s|;|$)#i', $acceptHeader, $matches)) {
            return 'v' . $matches[1];
        }

        return null;
    }

    /**
     * Get default API version from configuration
     *
     * @return string Default version (e.g., "v1")
     */
    protected function getDefaultVersion(): string
    {
        return config('api.default_version', 'v1');
    }

    /**
     * Check if a version is supported
     *
     * @param string $version Version to check (e.g., "v1")
     * @return bool True if supported
     */
    protected function isVersionSupported(string $version): bool
    {
        $supported = config('api.supported_versions', ['v1']);

        // If not an array, treat as always supported
        if (!is_array($supported)) {
            return true;
        }

        return in_array($version, $supported, true);
    }

    /**
     * Check if a version is deprecated
     *
     * @param string $version Version to check (e.g., "v1")
     * @return bool True if deprecated
     */
    protected function isVersionDeprecated(string $version): bool
    {
        $deprecated = config('api.deprecated_versions', []);

        // If not an array, treat as not deprecated
        if (!is_array($deprecated)) {
            return false;
        }

        return in_array($version, $deprecated, true);
    }

    /**
     * Extract numeric version from version string
     *
     * @param string $version Version string (e.g., "v1", "v2")
     * @return int Version number (e.g., 1, 2)
     */
    protected function extractVersionNumber(string $version): int
    {
        if (preg_match('#v(\d+)#i', $version, $matches)) {
            return (int) $matches[1];
        }

        return 1; // Default to version 1
    }
}
