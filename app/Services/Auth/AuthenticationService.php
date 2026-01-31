<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Constants\DatabaseTables;
use Core\Validation\Validator;

/**
 * Authentication Service
 *
 * Centralized business logic for authentication operations.
 * Consolidates duplicate code from AuthController and AuthApiController.
 */
class AuthenticationService
{
    /**
     * Validate registration data
     *
     * @param array $data Registration data
     * @return array ['success' => bool, 'errors' => array|null]
     */
    public function validateRegistration(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:' . DatabaseTables::AUSER . ',email',
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
     * Register new user
     *
     * @param array $data User data (name, email, password)
     * @return User Created user
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'] ?? '',
            'password' => $data['password'], // Auto-hashed by User model
            // Required auser table fields with defaults
            'is_admin' => 0,
            'is_super' => 0,
            'non_login' => 0,
            'ustatusid' => 1,
            'company_id' => 2018,
            'empid' => 0,
            'description' => '',
            'designation' => '',
            'email_signature' => '',
            'address_line_1' => '',
            'address_line_2' => '',
            'mail_box_hostname' => '',
            'mail_box_port' => 0,
            'mail_box_service' => '',
            'mail_box_username' => '',
            'mail_box_password' => '',
            'coverlid' => 0,
            'genderid' => 0,
            'zip_code' => '',
            'photo' => '',
            'licid' => 0,
            'hard_limit' => 0,
            'soft_limit' => 0,
            'is_multipler' => 0,
        ]);

        return $user;
    }

    /**
     * Validate login credentials
     *
     * @param array $data Login data
     * @return array ['success' => bool, 'errors' => array|null]
     */
    public function validateLogin(array $data): array
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
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
     * Attempt to log in user
     *
     * @param string $email User email
     * @param string $password User password
     * @param bool $remember Remember user (30 days)
     * @return bool Login success
     */
    public function login(string $email, string $password, bool $remember = false): bool
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        return auth()->attempt($credentials, $remember);
    }

    /**
     * Get currently authenticated user
     *
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return auth()->user();
    }

    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return auth()->check();
    }

    /**
     * Log out current user
     *
     * Destroys session and clears remember token.
     */
    public function logout(): void
    {
        auth()->logout();
    }

    /**
     * Transform user to safe array for API response
     *
     * Excludes sensitive fields like password, remember_token.
     *
     * @param User $user
     * @return array
     */
    public function userToArray(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
        ];
    }
}
