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

    /**
     * Create exception for account locked due to too many failed login attempts
     *
     * @param int $minutes Minutes until account is unlocked
     * @return static
     */
    public static function accountLocked(int $minutes): static
    {
        $message = sprintf(
            'Too many login attempts. Please try again in %d minute%s.',
            $minutes,
            $minutes === 1 ? '' : 's'
        );

        $exception = new static($message);
        $exception->code = 429; // 429 Too Many Requests
        return $exception;
    }
}
