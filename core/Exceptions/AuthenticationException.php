<?php

namespace Core\Exceptions;

/**
 * Authentication Exception
 *
 * Thrown when a user is not authenticated (401).
 * Redirects web users to login, returns JSON 401 for API requests.
 */
class AuthenticationException extends HttpException
{
    protected string $redirectTo;

    public function __construct(string $message = 'Unauthenticated.', string $redirectTo = '/login')
    {
        parent::__construct($message, 401);
        $this->redirectTo = $redirectTo;
    }

    /**
     * Get the redirect path for web requests
     */
    public function getRedirectTo(): string
    {
        return $this->redirectTo;
    }
}
