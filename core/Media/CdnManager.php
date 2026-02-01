<?php

namespace Core\Media;

/**
 * CdnManager
 *
 * Manages CDN URL generation and cache purging for media files.
 *
 * Features:
 * - URL rewriting to CDN domain
 * - Rules-based CDN usage (include/exclude patterns)
 * - CloudFront and Cloudflare support
 * - Cache purging capabilities
 *
 * Configuration in config/media.php under 'cdn' key:
 * - enabled: Enable/disable CDN
 * - url: CDN base URL
 * - rules: Include/exclude patterns
 * - cloudfront: CloudFront-specific settings
 * - cloudflare: Cloudflare-specific settings
 *
 * Usage:
 * ```php
 * $cdn = new CdnManager();
 *
 * // Get CDN URL for a path
 * $url = $cdn->getUrl('/products/image.jpg');
 *
 * // Check if path should use CDN
 * if ($cdn->shouldUseCdn($path)) {
 *     // Use CDN URL
 * }
 *
 * // Purge cache
 * $cdn->purge('/products/image.jpg');
 * ```
 */
class CdnManager
{
    /**
     * Whether CDN is enabled
     */
    protected bool $enabled;

    /**
     * CDN base URL
     */
    protected string $baseUrl;

    /**
     * CDN rules configuration
     */
    protected array $rules;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enabled = config('media.cdn.enabled', false);
        $this->baseUrl = rtrim(config('media.cdn.url', ''), '/');
        $this->rules = config('media.cdn.rules', []);
    }

    /**
     * Check if CDN is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->baseUrl);
    }

    /**
     * Get CDN URL for a path
     *
     * @param string $path Relative path to the file
     * @return string CDN URL or original path if CDN disabled
     */
    public function getUrl(string $path): string
    {
        // Sanitize path to prevent directory traversal
        $path = $this->sanitizePath($path);

        if (!$this->isEnabled()) {
            return $path;
        }

        // Ensure path starts with /
        $path = '/' . ltrim($path, '/');

        return $this->baseUrl . $path;
    }

    /**
     * Sanitize path to prevent directory traversal attacks
     *
     * @param string $path Input path
     * @return string Sanitized path
     */
    protected function sanitizePath(string $path): string
    {
        // Remove any directory traversal sequences
        $path = str_replace(['../', '..\\'], '', $path);

        // Remove any remaining .. components
        while (str_contains($path, '..')) {
            $path = str_replace('..', '', $path);
        }

        // Clean up multiple slashes
        $path = preg_replace('#/+#', '/', $path);

        return $path;
    }

    /**
     * Check if a path should use CDN
     *
     * @param string $path File path
     * @param string|null $mimeType Optional MIME type for type-based rules
     * @return bool True if CDN should be used
     */
    public function shouldUseCdn(string $path, ?string $mimeType = null): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        // Check exclude patterns first
        $excludePatterns = $this->rules['exclude_patterns'] ?? [];
        foreach ($excludePatterns as $pattern) {
            if (str_contains($path, $pattern)) {
                return false;
            }
        }

        // Check MIME type inclusion rules
        if ($mimeType !== null) {
            $includeTypes = $this->rules['include_types'] ?? [];

            if (!empty($includeTypes)) {
                $matched = false;
                foreach ($includeTypes as $typePattern) {
                    if ($this->matchMimeType($mimeType, $typePattern)) {
                        $matched = true;
                        break;
                    }
                }

                if (!$matched) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Match MIME type against pattern
     *
     * @param string $mimeType Actual MIME type (e.g., 'image/jpeg')
     * @param string $pattern Pattern to match (e.g., 'image/*')
     * @return bool True if matches
     */
    protected function matchMimeType(string $mimeType, string $pattern): bool
    {
        // Exact match
        if ($mimeType === $pattern) {
            return true;
        }

        // Wildcard match (e.g., 'image/*')
        if (str_ends_with($pattern, '/*')) {
            $prefix = substr($pattern, 0, -1);
            return str_starts_with($mimeType, $prefix);
        }

        return false;
    }

    /**
     * Purge CDN cache for a single path
     *
     * @param string $path Path to purge
     * @return bool True if purge request was successful
     */
    public function purge(string $path): bool
    {
        if (!$this->isEnabled()) {
            return true;
        }

        // Try CloudFront first
        $cloudfrontConfig = config('media.cdn.cloudfront', []);
        if (!empty($cloudfrontConfig['distribution_id'])) {
            return $this->purgeCloudFront([$path]);
        }

        // Try Cloudflare
        $cloudflareConfig = config('media.cdn.cloudflare', []);
        if (!empty($cloudflareConfig['zone_id'])) {
            return $this->purgeCloudflare([$path]);
        }

        // No CDN provider configured for purging
        return true;
    }

    /**
     * Purge CDN cache for multiple paths
     *
     * @param array $paths Paths to purge
     * @return array Results keyed by path
     */
    public function purgeMany(array $paths): array
    {
        if (!$this->isEnabled() || empty($paths)) {
            return array_fill_keys($paths, true);
        }

        // CloudFront can handle batch purges
        $cloudfrontConfig = config('media.cdn.cloudfront', []);
        if (!empty($cloudfrontConfig['distribution_id'])) {
            $success = $this->purgeCloudFront($paths);
            return array_fill_keys($paths, $success);
        }

        // Cloudflare can handle batch purges
        $cloudflareConfig = config('media.cdn.cloudflare', []);
        if (!empty($cloudflareConfig['zone_id'])) {
            $success = $this->purgeCloudflare($paths);
            return array_fill_keys($paths, $success);
        }

        return array_fill_keys($paths, true);
    }

    /**
     * Purge all CDN cache
     *
     * @return bool True if successful
     */
    public function purgeAll(): bool
    {
        if (!$this->isEnabled()) {
            return true;
        }

        // CloudFront
        $cloudfrontConfig = config('media.cdn.cloudfront', []);
        if (!empty($cloudfrontConfig['distribution_id'])) {
            return $this->purgeCloudFront(['/*']);
        }

        // Cloudflare
        $cloudflareConfig = config('media.cdn.cloudflare', []);
        if (!empty($cloudflareConfig['zone_id'])) {
            return $this->purgeCloudflareAll();
        }

        return true;
    }

    /**
     * Purge CloudFront cache
     *
     * @param array $paths Paths to invalidate
     * @return bool True if successful
     */
    protected function purgeCloudFront(array $paths): bool
    {
        $config = config('media.cdn.cloudfront', []);

        if (empty($config['distribution_id'])) {
            return false;
        }

        try {
            // Build invalidation paths
            $invalidationPaths = array_map(function ($path) {
                return '/' . ltrim($path, '/');
            }, $paths);

            // Use AWS CLI if available
            $distributionId = escapeshellarg($config['distribution_id']);
            $pathsJson = escapeshellarg(json_encode(['Paths' => [
                'Quantity' => count($invalidationPaths),
                'Items' => $invalidationPaths,
            ], 'CallerReference' => uniqid('inv-')]));

            $command = "aws cloudfront create-invalidation --distribution-id {$distributionId} --invalidation-batch {$pathsJson} 2>&1";

            exec($command, $output, $returnCode);

            return $returnCode === 0;

        } catch (\Exception $e) {
            if (function_exists('logger')) {
                logger()->error('CloudFront purge failed', [
                    'paths' => $paths,
                    'error' => $e->getMessage(),
                ]);
            }

            return false;
        }
    }

    /**
     * Purge Cloudflare cache
     *
     * @param array $paths Paths to purge
     * @return bool True if successful
     */
    protected function purgeCloudflare(array $paths): bool
    {
        $config = config('media.cdn.cloudflare', []);

        if (empty($config['zone_id']) || empty($config['api_token'])) {
            return false;
        }

        try {
            // Build full URLs
            $urls = array_map(function ($path) {
                return $this->getUrl($path);
            }, $paths);

            // Cloudflare API
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/{$config['zone_id']}/purge_cache",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(['files' => $urls]),
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $config['api_token'],
                    'Content-Type: application/json',
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            return $httpCode >= 200 && $httpCode < 300;

        } catch (\Exception $e) {
            if (function_exists('logger')) {
                logger()->error('Cloudflare purge failed', [
                    'paths' => $paths,
                    'error' => $e->getMessage(),
                ]);
            }

            return false;
        }
    }

    /**
     * Purge all Cloudflare cache
     *
     * @return bool True if successful
     */
    protected function purgeCloudflareAll(): bool
    {
        $config = config('media.cdn.cloudflare', []);

        if (empty($config['zone_id']) || empty($config['api_token'])) {
            return false;
        }

        try {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/{$config['zone_id']}/purge_cache",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode(['purge_everything' => true]),
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $config['api_token'],
                    'Content-Type: application/json',
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            return $httpCode >= 200 && $httpCode < 300;

        } catch (\Exception $e) {
            if (function_exists('logger')) {
                logger()->error('Cloudflare purge all failed', [
                    'error' => $e->getMessage(),
                ]);
            }

            return false;
        }
    }

    /**
     * Get CDN configuration
     *
     * @return array CDN configuration
     */
    public function getConfig(): array
    {
        return [
            'enabled' => $this->enabled,
            'url' => $this->baseUrl,
            'rules' => $this->rules,
            'cloudfront' => config('media.cdn.cloudfront', []),
            'cloudflare' => config('media.cdn.cloudflare', []),
        ];
    }
}
