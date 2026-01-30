<?php

namespace Core\Exceptions;

/**
 * Lockout Exception
 *
 * Thrown when a user is locked out due to too many failed login attempts (429).
 * Provides the number of seconds remaining until the lockout expires.
 */
class LockoutException extends HttpException
{
    /**
     * Seconds remaining until lockout expires
     */
    protected int $retryAfter;

    /**
     * Create a new LockoutException instance.
     *
     * @param int $retryAfter Seconds until the lockout expires
     * @param string $message Custom error message
     */
    public function __construct(int $retryAfter, string $message = '')
    {
        $this->retryAfter = $retryAfter;

        if ($message === '') {
            $minutes = (int) ceil($retryAfter / 60);
            $message = "Too many login attempts. Please try again in {$minutes} minute(s).";
        }

        parent::__construct($message, 429);
    }

    /**
     * Get the number of seconds until the lockout expires.
     *
     * @return int
     */
    public function getRetryAfter(): int
    {
        return $this->retryAfter;
    }

    /**
     * Get the recommended HTTP headers for the response.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return [
            'Retry-After' => $this->retryAfter,
            'X-RateLimit-Reset' => time() + $this->retryAfter,
        ];
    }
}
