<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * Password Reset Controller
 *
 * Handles password reset functionality
 */
class PasswordController
{
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect(url('/password/forgot'))
                ->withErrors($validator->errors())
                ->withInput();
        }

        $email = $request->input('email');
        $user = User::findByEmail($email);

        if (!$user) {
            // Don't reveal if email exists (security)
            return redirect(url('/password/forgot'))
                ->with('success', 'If that email exists in our system, a password reset link has been sent.');
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
        // For demo, display the reset link
        $resetUrl = url('/password/reset/' . $token);

        return redirect(url('/password/forgot'))
            ->with('success', 'Password reset link: ' . $resetUrl . ' (valid for 1 hour)');
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request, string $token): Response
    {
        // Verify token exists and is not expired
        $resetRecord = app('db')->table('password_resets')
            ->where('token', '=', hash('sha256', $token))
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors());
        }

        $token = $request->input('token');
        $email = $request->input('email');

        // Verify token
        $resetRecord = app('db')->table('password_resets')
            ->where('token', '=', hash('sha256', $token))
            ->where('email', '=', $email)
            ->first();

        if (!$resetRecord) {
            return redirect(url('/password/forgot'))
                ->with('error', 'Invalid reset token.');
        }

        // Check expiration
        if (strtotime($resetRecord['expires_at']) < time()) {
            return redirect(url('/password/forgot'))
                ->with('error', 'This reset token has expired.');
        }

        // Find user and update password
        $user = User::findByEmail($email);

        if (!$user) {
            return redirect(url('/password/forgot'))
                ->with('error', 'User not found.');
        }

        // Update password (automatically hashed by User model)
        $user->password = $request->input('password');
        $user->save();

        // Delete used token
        app('db')->table('password_resets')
            ->where('email', '=', $email)
            ->delete();

        return redirect(url('/login'))
            ->with('success', 'Password reset successfully! You can now login with your new password.');
    }
}
