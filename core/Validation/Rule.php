<?php

namespace Core\Validation;

/**
 * Rule Interface
 *
 * Interface for custom validation rules.
 *
 * Usage:
 *   class Uppercase implements Rule
 *   {
 *       public function passes(string $attribute, $value): bool
 *       {
 *           return strtoupper($value) === $value;
 *       }
 *
 *       public function message(): string
 *       {
 *           return 'The :attribute must be uppercase.';
 *       }
 *   }
 *
 *   $validator = new Validator($data, [
 *       'name' => ['required', new Uppercase],
 *   ]);
 */
interface Rule
{
    /**
     * Determine if the validation rule passes
     *
     * @param string $attribute Field name
     * @param mixed $value Field value
     * @return bool
     */
    public function passes(string $attribute, $value): bool;

    /**
     * Get the validation error message
     *
     * @return string
     */
    public function message(): string;
}
