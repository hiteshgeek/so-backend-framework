<?php

namespace App\Controllers\Auth;

use App\Services\Auth\PasswordResetService;
use App\Validation\PasswordValidationRules;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * Password Reset Controller
 *
 * Handles password reset functionality for web interface.
 * Uses PasswordResetService for business logic.
 */
class PasswordController
{
    private PasswordResetService $passwordResetService;

    public function __construct()
    {
        $this->passwordResetService = new PasswordResetService();
    }

    /**
     * Show forgot password form
     */
    public function showForgotForm(Request $request): Response
    {
        return Response::view('auth/forgot', [
            'title' => 'Forgot Password - ' . config('app.name'),
            'errors' => session('errors', []),
            'old' => session('_old_input', []),
        ]);
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request): Response
    {
        // Validate using centralized rules
        $validator = Validator::make($request->all(), PasswordValidationRules::forgotPassword());

        if ($validator->fails()) {
            return redirect(url('/password/forgot'))
                ->withErrors($validator->errors())
                ->withInput();
        }

        $email = $request->input('email');

        // Check if user exists
        if (!$this->passwordResetService->userExists($email)) {
            // Don't reveal if email exists (security)
            return redirect(url('/password/forgot'))
                ->with('success', 'If that email exists in our system, a password reset link has been sent.');
        }

        // Generate and store token via service
        $token = $this->passwordResetService->createResetToken($email);

        // In production, send email with reset link
        // For demo, display the reset link
        $resetUrl = $this->passwordResetService->buildResetUrl($token);

        return redirect(url('/password/forgot'))
            ->with('success', 'Password reset link: ' . $resetUrl . ' (valid for 1 hour)');
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request, string $token): Response
    {
        // Note: We can't fully verify token without email at this stage
        // The verification happens during actual password reset

        // Get email from token record if exists
        $hashedToken = hash('sha256', $token);
        $resetRecord = app('db')->table('password_resets')
            ->where('token', '=', $hashedToken)
            ->first();

        if (!$resetRecord) {
            return redirect(url('/password/forgot'))
                ->with('error', 'Invalid or expired reset token.');
        }

        // Check if token is expired
        if (strtotime($resetRecord['expires_at']) < time()) {
            return redirect(url('/password/forgot'))
                ->with('error', 'This reset token has expired. Please request a new one.');
        }

        return Response::view('auth/reset', [
            'title' => 'Reset Password - ' . config('app.name'),
            'token' => $token,
            'email' => $resetRecord['email'],
            'errors' => session('errors', []),
        ]);
    }

    /**
     * Process password reset
     */
    public function reset(Request $request): Response
    {
        // Validate using centralized rules
        $validator = Validator::make($request->all(), PasswordValidationRules::resetPassword());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors());
        }

        // Reset password via service
        $success = $this->passwordResetService->resetPassword(
            $request->input('token'),
            $request->input('email'),
            $request->input('password')
        );

        if (!$success) {
            return redirect(url('/password/forgot'))
                ->with('error', 'Invalid or expired reset token.');
        }

        return redirect(url('/login'))
            ->with('success', 'Password reset successfully! You can now login with your new password.');
    }
}
