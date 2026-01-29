<?php

namespace Core\Api;

use Core\Http\Request;

/**
 * Request Context Detector
 *
 * Detects the context of incoming requests:
 * - web: Browser requests with session authentication
 * - mobile: Mobile app requests with JWT authentication
 * - cron: Scheduled tasks with signature authentication
 * - external: External API calls with API key authentication
 *
 * Usage:
 *   $context = RequestContext::detect($request);
 *   if ($context->isWeb()) { ... }
 *   if ($context->isMobile()) { ... }
 */
class RequestContext
{
    /**
     * Context types
     */
    public const WEB = 'web';
    public const MOBILE = 'mobile';
    public const CRON = 'cron';
    public const EXTERNAL = 'external';

    /**
     * Current context
     */
    protected string $context;

    /**
     * Request instance
     */
    protected Request $request;

    /**
     * Constructor
     *
     * @param string $context Context type
     * @param Request $request Request instance
     */
    public function __construct(string $context, Request $request)
    {
        $this->context = $context;
        $this->request = $request;
    }

    /**
     * Detect context from request
     *
     * @param Request $request
     * @return self
     */
    public static function detect(Request $request): self
    {
        // Priority order: cron > external > mobile > web

        // 1. Check for cron (signature authentication)
        if (self::isCronRequest($request)) {
            return new self(self::CRON, $request);
        }

        // 2. Check for external API (API key)
        if (self::isExternalRequest($request)) {
            return new self(self::EXTERNAL, $request);
        }

        // 3. Check for mobile app (JWT + mobile user agent)
        if (self::isMobileRequest($request)) {
            return new self(self::MOBILE, $request);
        }

        // 4. Default to web (session-based)
        return new self(self::WEB, $request);
    }

    /**
     * Check if request is from cron/CLI
     *
     * @param Request $request
     * @return bool
     */
    protected static function isCronRequest(Request $request): bool
    {
        // Check for signature headers (primary method)
        if ($request->header('X-Signature') && $request->header('X-Timestamp')) {
            return true;
        }

        // Check for cron-specific header
        if ($request->header('X-Cron-Job')) {
            return true;
        }

        // Only consider CLI as cron if there are no other context indicators
        // (no user agent, no JWT, no API key)
        if (php_sapi_name() === 'cli') {
            $hasUserAgent = !empty($request->userAgent());
            $hasJwt = !empty($request->bearerToken());
            $hasApiKey = !empty($request->header('X-Api-Key'));

            // Only cron if it's CLI and has none of the above
            if (!$hasUserAgent && !$hasJwt && !$hasApiKey) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if request is from external API
     *
     * @param Request $request
     * @return bool
     */
    protected static function isExternalRequest(Request $request): bool
    {
        // Check for API key header
        $apiKey = $request->header('X-Api-Key');
        if ($apiKey) {
            return true;
        }

        // Check for external API marker
        if ($request->header('X-External-Api')) {
            return true;
        }

        return false;
    }

    /**
     * Check if request is from mobile app
     *
     * @param Request $request
     * @return bool
     */
    protected static function isMobileRequest(Request $request): bool
    {
        // Check for JWT token
        if (!$request->bearerToken()) {
            return false;
        }

        // Check user agent for mobile indicators
        $userAgent = strtolower($request->userAgent() ?? '');

        $mobileIndicators = [
            'android',
            'iphone',
            'ipad',
            'mobile',
            'ios',
            'okhttp',      // Android HTTP client
            'alamofire',   // iOS HTTP client
        ];

        foreach ($mobileIndicators as $indicator) {
            if (str_contains($userAgent, $indicator)) {
                return true;
            }
        }

        // Check for mobile app header
        if ($request->header('X-Mobile-App')) {
            return true;
        }

        return false;
    }

    /**
     * Get context type
     *
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * Check if context is web
     *
     * @return bool
     */
    public function isWeb(): bool
    {
        return $this->context === self::WEB;
    }

    /**
     * Check if context is mobile
     *
     * @return bool
     */
    public function isMobile(): bool
    {
        return $this->context === self::MOBILE;
    }

    /**
     * Check if context is cron
     *
     * @return bool
     */
    public function isCron(): bool
    {
        return $this->context === self::CRON;
    }

    /**
     * Check if context is external API
     *
     * @return bool
     */
    public function isExternal(): bool
    {
        return $this->context === self::EXTERNAL;
    }

    /**
     * Check if context is API (mobile or external)
     *
     * @return bool
     */
    public function isApi(): bool
    {
        return $this->isMobile() || $this->isExternal();
    }

    /**
     * Get request instance
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Convert to string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->context;
    }

    /**
     * Get all context types
     *
     * @return array
     */
    public static function getAllContexts(): array
    {
        return [
            self::WEB,
            self::MOBILE,
            self::CRON,
            self::EXTERNAL,
        ];
    }
}
