<?php

namespace Core\Exceptions;

use Exception;

/**
 * HTTP Exception
 *
 * Exception for HTTP errors
 */
class HttpException extends Exception
{
    /**
     * HTTP status code
     *
     * @var int
     */
    protected $code;

    /**
     * Constructor
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = '', int $code = 500, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get status code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->code;
    }
}
