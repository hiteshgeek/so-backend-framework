<?php

/**
 * English Authentication Messages
 *
 * Authentication and authorization related messages for API responses.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    */

    // Login
    'login_success' => 'Login successful!',
    'login_failed' => 'Invalid email or password.',
    'invalid_credentials' => 'Invalid credentials.',

    // Registration
    'registration_success' => 'Account created successfully!',
    'registration_failed' => 'Registration failed. Please try again.',

    // Logout
    'logout_success' => 'Logged out successfully.',

    // Password Reset
    'password_reset_sent' => 'Password reset link sent to your email.',
    'password_reset_success' => 'Password reset successfully! You can now login with your new password.',
    'password_reset_failed' => 'Password reset failed. Please try again.',
    'password_reset_token_invalid' => 'Invalid or expired password reset token.',
    'password_reset_token_expired' => 'Password reset token has expired.',

    // Password Change
    'password_change_success' => 'Password changed successfully.',
    'password_change_failed' => 'Current password is incorrect.',

    // Authorization
    'unauthorized' => 'You are not authorized to access this resource.',
    'unauthenticated' => 'You must be logged in to access this resource.',
    'access_denied' => 'Access denied.',
    'forbidden' => 'This action is forbidden.',

    // Token
    'token_invalid' => 'Invalid authentication token.',
    'token_expired' => 'Authentication token has expired.',
    'token_missing' => 'Authentication token is missing.',
    'token_revoked' => 'Authentication token has been revoked.',

    // Account Status
    'account_inactive' => 'Your account is inactive. Please contact support.',
    'account_suspended' => 'Your account has been suspended.',
    'account_deleted' => 'Your account has been deleted.',

    // Email Verification
    'email_verification_sent' => 'Verification email sent.',
    'email_verified' => 'Email verified successfully.',
    'email_not_verified' => 'Email address is not verified.',
    'email_already_verified' => 'Email address is already verified.',
];
