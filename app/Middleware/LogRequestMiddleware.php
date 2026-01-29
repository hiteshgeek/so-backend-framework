<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Core\Http\Response;

/**
 * Log Request Middleware
 *
 * Logs all incoming HTTP requests and responses for debugging and monitoring.
 * Useful for tracking API usage, performance metrics, and troubleshooting.
 *
 * Configuration:
 *   - Enable/disable via LOG_REQUESTS in .env
 *   - Sensitive data (passwords, tokens) is automatically filtered
 */
class LogRequestMiddleware implements MiddlewareInterface
{
    /**
     * Sensitive fields to exclude from logs
     */
    protected array $sensitiveFields = [
        'password',
        'password_confirmation',
        'token',
        'secret',
        'api_key',
        'authorization',
        'card_number',
        'cvv',
        'ssn',
    ];

    /**
     * Handle request
     *
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function handle(Request $request, callable $next): Response
    {
        // Check if logging is enabled
        if (!$this->isEnabled()) {
            return $next($request);
        }

        // Record start time
        $startTime = microtime(true);

        // Log incoming request
        $this->logRequest($request);

        // Continue with request
        $response = $next($request);

        // Calculate duration
        $duration = round((microtime(true) - $startTime) * 1000, 2);

        // Log response
        $this->logResponse($request, $response, $duration);

        return $response;
    }

    /**
     * Log incoming request
     *
     * @param Request $request
     * @return void
     */
    protected function logRequest(Request $request): void
    {
        $data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'method' => $request->method(),
            'uri' => $request->uri(),
            'ip' => $this->getClientIp($request),
            'user_agent' => $request->header('User-Agent'),
            'input' => $this->filterSensitiveData($request->all()),
        ];

        // Add user ID if authenticated
        if (isset($request->user_id)) {
            $data['user_id'] = $request->user_id;
        }

        $this->log('info', 'Incoming Request', $data);
    }

    /**
     * Log response
     *
     * @param Request $request
     * @param Response $response
     * @param float $duration Duration in milliseconds
     * @return void
     */
    protected function logResponse(Request $request, Response $response, float $duration): void
    {
        $data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'method' => $request->method(),
            'uri' => $request->uri(),
            'status' => $response->getStatusCode(),
            'duration' => $duration . 'ms',
        ];

        // Log level based on status code
        $level = $this->getLogLevel($response->getStatusCode());

        $this->log($level, 'Response', $data);
    }

    /**
     * Filter sensitive data from array
     *
     * @param array $data
     * @return array
     */
    protected function filterSensitiveData(array $data): array
    {
        $filtered = [];

        foreach ($data as $key => $value) {
            // Check if field is sensitive
            if ($this->isSensitiveField($key)) {
                $filtered[$key] = '[FILTERED]';
            } elseif (is_array($value)) {
                $filtered[$key] = $this->filterSensitiveData($value);
            } else {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Check if field name is sensitive
     *
     * @param string $field
     * @return bool
     */
    protected function isSensitiveField(string $field): bool
    {
        $field = strtolower($field);

        foreach ($this->sensitiveFields as $sensitive) {
            if (str_contains($field, $sensitive)) {
                return true;
            }
        }

        return false;
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
     * Get log level based on HTTP status code
     *
     * @param int $statusCode
     * @return string
     */
    protected function getLogLevel(int $statusCode): string
    {
        if ($statusCode >= 500) {
            return 'error';
        }

        if ($statusCode >= 400) {
            return 'warning';
        }

        return 'info';
    }

    /**
     * Write log entry
     *
     * @param string $level
     * @param string $message
     * @param array $context
     * @return void
     */
    protected function log(string $level, string $message, array $context = []): void
    {
        // Use activity logger if available
        if (function_exists('activity')) {
            activity('http')
                ->withProperties($context)
                ->log($message);
            return;
        }

        // Fallback to error_log
        $logMessage = sprintf(
            '[%s] %s: %s %s',
            strtoupper($level),
            $message,
            json_encode($context),
            PHP_EOL
        );

        error_log($logMessage);
    }

    /**
     * Check if logging is enabled
     *
     * @return bool
     */
    protected function isEnabled(): bool
    {
        return config('logging.log_requests', env('LOG_REQUESTS', false));
    }
}
