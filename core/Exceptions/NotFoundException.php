<?php

namespace Core\Exceptions;

/**
 * Not Found Exception
 *
 * 404 exception
 */
class NotFoundException extends HttpException
{
    /**
     * Constructor
     *
     * @param string $message
     */
    public function __construct(string $message = 'Not Found')
    {
        parent::__construct($message, 404);
    }
}
