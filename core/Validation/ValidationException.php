<?php

namespace Core\Validation;

use Exception;

/**
 * ValidationException
 *
 * Thrown when validation fails. Contains validation errors.
 */
class ValidationException extends Exception
{
    /**
     * Validation errors
     */
    protected array $errors;

    /**
     * Constructor
     *
     * @param array $errors Validation errors
     * @param string $message Exception message
     * @param int $code Exception code
     */
    public function __construct(array $errors, string $message = 'The given data was invalid.', int $code = 422)
    {
        parent::__construct($message, $code);
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

    /**
     * Get first error message
     *
     * @return string|null
     */
    public function getFirstError(): ?string
    {
        foreach ($this->errors as $field => $messages) {
            if (!empty($messages)) {
                return is_array($messages) ? $messages[0] : $messages;
            }
        }

        return null;
    }

    /**
     * Convert to JSON response
     *
     * @return \Core\Http\JsonResponse
     */
    public function toResponse()
    {
        return \Core\Http\JsonResponse::error($this->getMessage(), $this->getCode(), [
            'errors' => $this->errors
        ]);
    }
}
