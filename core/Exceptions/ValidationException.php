<?php

namespace Core\Exceptions;

/**
 * Validation Exception
 *
 * Exception for validation errors
 */
class ValidationException extends Exception
{
    /**
     * Validation errors
     *
     * @var array
     */
    protected array $errors;

    /**
     * Constructor
     *
     * @param string $message
     * @param array $errors
     */
    public function __construct(string $message = 'Validation failed', array $errors = [])
    {
        parent::__construct($message, 422);
        $this->errors = $errors;
    }

    /**
     * Get validation errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
