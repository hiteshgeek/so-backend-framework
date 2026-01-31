<?php

namespace App\Validation;

/**
 * User Validation Rules
 *
 * Centralized validation rules for user operations.
 * Eliminates duplicate validation logic across controllers.
 */
class UserValidationRules
{
    /**
     * Validation rules for user registration
     *
     * Used by: AuthController, AuthApiController, UserApiController
     *
     * @return array Validation rules
     */
    public static function registration(): array
    {
        return [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    /**
     * Validation rules for user update
     *
     * Password is optional for updates.
     * Used by: DashboardController, UserApiController
     *
     * @param bool $requirePassword Whether password is required
     * @return array Validation rules
     */
    public static function update(bool $requirePassword = false): array
    {
        $rules = [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email',
        ];

        if ($requirePassword) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        return $rules;
    }

    /**
     * Validation rules for optional password update
     *
     * Returns conditional rules array for password updates.
     * Used when password field is optional but must be validated if provided.
     *
     * @return array Validation rules for password
     */
    public static function passwordUpdate(): array
    {
        return [
            'password' => 'min:8|confirmed',
        ];
    }

    /**
     * Validation rules for user login
     *
     * @return array Validation rules
     */
    public static function login(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
