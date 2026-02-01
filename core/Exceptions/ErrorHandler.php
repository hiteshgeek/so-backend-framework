<?php

namespace Core\Exceptions;

use Throwable;

/**
 * Error Handler
 *
 * Handles exceptions and renders appropriate error pages.
 */
class ErrorHandler
{
    /**
     * Handle an exception
     *
     * @param Throwable $exception
     * @return void
     */
    public static function handle(Throwable $exception): void
    {
        // Determine status code
        $statusCode = self::getStatusCode($exception);

        // Log the exception
        self::logException($exception);

        // Render error page
        self::render($statusCode, $exception);
    }

    /**
     * Get HTTP status code from exception
     *
     * @param Throwable $exception
     * @return int
     */
    protected static function getStatusCode(Throwable $exception): int
    {
        // Check if exception has getStatusCode method
        if (method_exists($exception, 'getStatusCode')) {
            return $exception->getStatusCode();
        }

        // Check if exception code is a valid HTTP status code
        if ($exception->getCode() >= 400 && $exception->getCode() < 600) {
            return $exception->getCode();
        }

        // Map exception types to status codes
        $class = get_class($exception);
        return match ($class) {
            NotFoundException::class => 404,
            AuthenticationException::class => 401,
            AuthorizationException::class => 403,
            \Core\Validation\ValidationException::class => 422,
            default => 500,
        };
    }

    /**
     * Log exception
     *
     * @param Throwable $exception
     * @return void
     */
    protected static function logException(Throwable $exception): void
    {
        try {
            $logger = logger();
            $logger->error($exception->getMessage(), [
                'exception' => $exception,
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        } catch (\Throwable $e) {
            // Logging failed, continue without logging
            error_log($exception->getMessage());
        }
    }

    /**
     * Render error page
     *
     * @param int $statusCode
     * @param Throwable $exception
     * @return void
     */
    protected static function render(int $statusCode, Throwable $exception): void
    {
        // Set HTTP status code
        http_response_code($statusCode);

        // Check if custom error view exists
        $errorView = base_path("resources/views/errors/{$statusCode}.php");

        if (file_exists($errorView)) {
            // Render custom error page
            self::renderErrorView($errorView, $exception);
        } else {
            // Fallback to generic error page
            self::renderGenericError($statusCode, $exception);
        }
    }

    /**
     * Render error view
     *
     * @param string $viewPath
     * @param Throwable $exception
     * @return void
     */
    protected static function renderErrorView(string $viewPath, Throwable $exception): void
    {
        // Extract variables for the view
        $errors = method_exists($exception, 'errors') ? $exception->errors() : [];

        // Include the error view
        require $viewPath;
    }

    /**
     * Render generic error page
     *
     * @param int $statusCode
     * @param Throwable $exception
     * @return void
     */
    protected static function renderGenericError(int $statusCode, Throwable $exception): void
    {
        $message = $exception->getMessage() ?: self::getDefaultMessage($statusCode);

        if (config('app.debug')) {
            // Debug mode - show detailed error
            self::renderDebugError($statusCode, $exception);
        } else {
            // Production mode - show simple error
            echo "<!DOCTYPE html>
<html>
<head>
    <title>Error {$statusCode}</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 50px; }
        h1 { font-size: 48px; margin: 20px 0; }
        p { color: #666; font-size: 18px; }
    </style>
</head>
<body>
    <h1>{$statusCode}</h1>
    <p>" . htmlspecialchars($message) . "</p>
</body>
</html>";
        }
    }

    /**
     * Render debug error page
     *
     * @param int $statusCode
     * @param Throwable $exception
     * @return void
     */
    protected static function renderDebugError(int $statusCode, Throwable $exception): void
    {
        echo "<!DOCTYPE html>
<html>
<head>
    <title>Error {$statusCode} - Debug Mode</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #f5f5f5; }
        .error-box { background: white; padding: 20px; border-left: 4px solid #dc2626; margin-bottom: 20px; }
        .error-title { font-size: 24px; font-weight: bold; color: #dc2626; margin-bottom: 10px; }
        .error-message { font-size: 16px; margin-bottom: 10px; }
        .error-location { color: #666; margin-bottom: 10px; }
        .stack-trace { background: #f9f9f9; padding: 15px; overflow-x: auto; font-size: 12px; border: 1px solid #ddd; }
        pre { margin: 0; white-space: pre-wrap; word-wrap: break-word; }
    </style>
</head>
<body>
    <div class=\"error-box\">
        <div class=\"error-title\">Error {$statusCode}: " . htmlspecialchars(get_class($exception)) . "</div>
        <div class=\"error-message\">" . htmlspecialchars($exception->getMessage()) . "</div>
        <div class=\"error-location\">
            <strong>File:</strong> " . htmlspecialchars($exception->getFile()) . ":{$exception->getLine()}
        </div>
    </div>
    <div class=\"stack-trace\">
        <strong>Stack Trace:</strong>
        <pre>" . htmlspecialchars($exception->getTraceAsString()) . "</pre>
    </div>
</body>
</html>";
    }

    /**
     * Get default error message for status code
     *
     * @param int $statusCode
     * @return string
     */
    protected static function getDefaultMessage(int $statusCode): string
    {
        return match ($statusCode) {
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            422 => 'Unprocessable Entity',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            default => "HTTP Error {$statusCode}",
        };
    }
}
