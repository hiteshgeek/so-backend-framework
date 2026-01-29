<?php

namespace Core\Middleware;

use Core\Http\Request;
use Core\Http\Response;

/**
 * Middleware Interface
 */
interface MiddlewareInterface
{
    /**
     * Handle request
     *
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function handle(Request $request, callable $next): Response;
}
