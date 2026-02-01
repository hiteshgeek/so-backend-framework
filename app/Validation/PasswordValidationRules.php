<?php

namespace App\Validation;

/**
 * Password Validation Rules
 *
 * Centralized validation rules for password reset operations.
 * Eliminates duplicate validation logic across password controllers.
 */
class PasswordValidationRules
{
    /**
     * Validation rules for forgot password request
     *
     * Used by: PasswordController, PasswordApiController
     *
     * @return array Validation rules
     */
    public static function forgotPassword(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    /**
     * Validation rules for password reset
     *
     * Used by: PasswordController, PasswordApiController
     *
     * @return array Validation rules
     */
    public static function resetPassword(): array
    {
        return [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ];
    }

    /**
     * Validation rules for password change (authenticated user)
     *
     * For use when user is logged in and changing their password.
     *
     * @return array Validation rules
     */
    public static function changePassword(): array
    {
        return [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ];
    }
}
