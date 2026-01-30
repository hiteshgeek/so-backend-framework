<?php

namespace Core\Exceptions;

/**
 * Authorization Exception
 *
 * Thrown when a user is authenticated but not authorized (403).
 */
class AuthorizationException extends HttpException
{
    public function __construct(string $message = 'This action is unauthorized.')
    {
        parent::__construct($message, 403);
    }
}
