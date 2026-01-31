<?php

namespace App\Services\Auth;

use App\Models\User;
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
            'email' => 'required|email|unique:users,email',
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
            'password' => $data['password'], // Auto-hashed by User model
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
