<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\JsonResponse;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * API Password Reset Controller
 *
 * Returns JSON responses for password reset requests
 */
class PasswordApiController
{
    /**
     * API Forgot Password - Request reset token
     *
     * POST /api/password/forgot
     */
    public function sendResetLink(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        $email = $request->input('email');
        $user = User::findByEmail($email);

        // Always return success to prevent user enumeration
        if (!$user) {
            return JsonResponse::success([
                'message' => 'If that email exists in our system, a password reset link has been sent.',
            ]);
        }

        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Delete any existing reset tokens for this email
        app('db')->table('password_resets')
            ->where('email', '=', $email)
            ->delete();

        // Store hashed token in database
        app('db')->table('password_resets')->insert([
            'email' => $email,
            'token' => hash('sha256', $token),
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => $expiresAt,
        ]);

        // In production, send email with reset link
        // For demo, return the reset token
        $resetUrl = url('/password/reset/' . $token);

        return JsonResponse::success([
            'message' => 'Password reset link generated successfully',
            'demo_reset_url' => $resetUrl,
            'demo_token' => $token,
            'expires_in' => '1 hour',
        ]);
    }

    /**
     * API Reset Password - Update password with token
     *
     * POST /api/password/reset
     */
    public function reset(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        $token = $request->input('token');
        $email = $request->input('email');

        // Verify token
        $resetRecord = app('db')->table('password_resets')
            ->where('token', '=', hash('sha256', $token))
            ->where('email', '=', $email)
            ->first();

        if (!$resetRecord) {
            return JsonResponse::error('Invalid reset token', 400);
        }

        // Check expiration
        if (strtotime($resetRecord['expires_at']) < time()) {
            return JsonResponse::error('This reset token has expired', 400);
        }

        // Find user and update password
        $user = User::findByEmail($email);

        if (!$user) {
            return JsonResponse::error('User not found', 404);
        }

        // Update password (automatically hashed by User model)
        $user->password = $request->input('password');
        $user->save();

        // Delete used token
        app('db')->table('password_resets')
            ->where('email', '=', $email)
            ->delete();

        return JsonResponse::success([
            'message' => 'Password reset successfully! You can now login with your new password.',
        ]);
    }
}
