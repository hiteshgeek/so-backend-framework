<?php

namespace Core\Middleware;

use Core\Http\Request;
use Core\Http\Response;

/**
 * Terminable Middleware Interface
 *
 * Middleware implementing this interface will have their terminate() method
 * called after the response has been sent to the client. This is useful for:
 *
 * - Logging request/response data
 * - Sending queued notifications
 * - Cleaning up resources
 * - Recording metrics
 * - Session management cleanup
 *
 * Usage:
 *   class LoggingMiddleware implements TerminableMiddleware
 *   {
 *       public function handle(Request $request, callable $next): Response
 *       {
 *           // Before request handling
 *           $startTime = microtime(true);
 *
 *           $response = $next($request);
 *
 *           // Store timing for terminate phase
 *           $request->attributes['request_time'] = microtime(true) - $startTime;
 *
 *           return $response;
 *       }
 *
 *       public function terminate(Request $request, Response $response): void
 *       {
 *           // This runs after response is sent
 *           $time = $request->attributes['request_time'] ?? 0;
 *           logger()->info('Request completed', [
 *               'uri' => $request->uri(),
 *               'method' => $request->method(),
 *               'status' => $response->getStatusCode(),
 *               'time' => $time,
 *           ]);
 *       }
 *   }
 *
 * Note: The terminate phase must be manually triggered in your application's
 * entry point after sending the response:
 *
 *   $response->send();
 *   $router->terminate($request, $response);
 */
interface TerminableMiddleware
{
    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function handle(Request $request, callable $next): Response;

    /**
     * Handle tasks after the response has been sent
     *
     * This method is called after the HTTP response has been sent to the client.
     * Any exceptions thrown here will not affect the response but may be logged.
     *
     * @param Request $request The original request
     * @param Response $response The response that was sent
     * @return void
     */
    public function terminate(Request $request, Response $response): void;
}
