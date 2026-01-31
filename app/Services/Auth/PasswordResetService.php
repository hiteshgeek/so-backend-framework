<?php

namespace App\Services\Auth;

use App\Models\User;
use Core\Validation\Validator;

/**
 * Password Reset Service
 *
 * Centralized business logic for password reset operations.
 * Consolidates duplicate code from PasswordController and PasswordApiController.
 */
class PasswordResetService
{
    private const TOKEN_LENGTH = 32;
    private const TOKEN_EXPIRY_HOURS = 1;

    /**
     * Validate forgot password request
     *
     * @param array $data Request data
     * @return array ['success' => bool, 'errors' => array|null]
     */
    public function validateForgotPassword(array $data): array
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        return ['success' => true];
    }

    /**
     * Validate password reset request
     *
     * @param array $data Request data
     * @return array ['success' => bool, 'errors' => array|null]
     */
    public function validatePasswordReset(array $data): array
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        return ['success' => true];
    }

    /**
     * Generate and store password reset token
     *
     * @param string $email User email
     * @return string Unhashed token (for sending in email)
     */
    public function createResetToken(string $email): string
    {
        // Generate secure random token
        $token = bin2hex(random_bytes(self::TOKEN_LENGTH));
        $hashedToken = hash('sha256', $token);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+' . self::TOKEN_EXPIRY_HOURS . ' hour'));

        // Delete any existing reset tokens for this email
        app('db')->table('password_resets')
            ->where('email', '=', $email)
            ->delete();

        // Store hashed token in database
        app('db')->table('password_resets')->insert([
            'email' => $email,
            'token' => $hashedToken,
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => $expiresAt,
        ]);

        return $token; // Return unhashed token for email
    }

    /**
     * Verify reset token is valid and not expired
     *
     * @param string $token Unhashed token from email
     * @param string $email User email
     * @return array|null Reset record or null if invalid/expired
     */
    public function verifyToken(string $token, string $email): ?array
    {
        $hashedToken = hash('sha256', $token);

        $resetRecord = app('db')->table('password_resets')
            ->where('token', '=', $hashedToken)
            ->where('email', '=', $email)
            ->first();

        if (!$resetRecord) {
            return null;
        }

        // Check if token has expired
        if (strtotime($resetRecord['expires_at']) < time()) {
            return null;
        }

        return (array) $resetRecord;
    }

    /**
     * Reset user password using token
     *
     * @param string $token Reset token
     * @param string $email User email
     * @param string $newPassword New password
     * @return bool Success
     */
    public function resetPassword(string $token, string $email, string $newPassword): bool
    {
        // Verify token is valid
        $resetRecord = $this->verifyToken($token, $email);
        if (!$resetRecord) {
            return false;
        }

        // Find user by email
        $user = User::where('email', '=', $email)->first();
        if (!$user) {
            return false;
        }

        // Update password (auto-hashed by User model)
        $user->password = $newPassword;
        $user->save();

        // Delete used token
        $this->deleteToken($email);

        return true;
    }

    /**
     * Delete reset token for email
     *
     * @param string $email User email
     */
    public function deleteToken(string $email): void
    {
        app('db')->table('password_resets')
            ->where('email', '=', $email)
            ->delete();
    }

    /**
     * Check if user exists by email
     *
     * @param string $email User email
     * @return bool User exists
     */
    public function userExists(string $email): bool
    {
        $user = User::where('email', '=', $email)->first();
        return $user !== null;
    }

    /**
     * Build reset URL for token
     *
     * @param string $token Reset token
     * @return string Reset URL
     */
    public function buildResetUrl(string $token): string
    {
        return url('/password/reset/' . $token);
    }
}
