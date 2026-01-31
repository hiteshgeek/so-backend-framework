<?php

namespace App\Controllers\Auth;

use App\Services\Auth\PasswordResetService;
use App\Validation\PasswordValidationRules;
use Core\Http\JsonResponse;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * API Password Reset Controller
 *
 * Returns JSON responses for password reset requests.
 * Uses PasswordResetService for business logic.
 */
class PasswordApiController
{
    private PasswordResetService $passwordResetService;

    public function __construct()
    {
        $this->passwordResetService = new PasswordResetService();
    }

    /**
     * API Forgot Password - Request reset token
     *
     * POST /api/password/forgot
     */
    public function sendResetLink(Request $request): Response
    {
        // Validate using centralized rules
        $validator = Validator::make($request->all(), PasswordValidationRules::forgotPassword());

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        $email = $request->input('email');

        // Always return success to prevent user enumeration (even if user doesn't exist)
        if (!$this->passwordResetService->userExists($email)) {
            return JsonResponse::success([
                'message' => 'If that email exists in our system, a password reset link has been sent.',
            ]);
        }

        // Generate and store token via service
        $token = $this->passwordResetService->createResetToken($email);

        // In production, send email with reset link
        // For demo, return the reset token and URL
        $resetUrl = $this->passwordResetService->buildResetUrl($token);

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
        // Validate using centralized rules
        $validator = Validator::make($request->all(), PasswordValidationRules::resetPassword());

        if ($validator->fails()) {
            return JsonResponse::error('Validation failed', 422, [
                'errors' => $validator->errors()
            ]);
        }

        // Reset password via service
        $success = $this->passwordResetService->resetPassword(
            $request->input('token'),
            $request->input('email'),
            $request->input('password')
        );

        if (!$success) {
            return JsonResponse::error('Invalid or expired reset token', 400);
        }

        return JsonResponse::success([
            'message' => 'Password reset successfully! You can now login with your new password.',
        ]);
    }
}
