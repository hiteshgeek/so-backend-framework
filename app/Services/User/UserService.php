<?php

namespace App\Services\User;

use App\Models\User;
use Core\Validation\Validator;

/**
 * User Service
 *
 * Centralized business logic for user operations.
 * Consolidates duplicate code from UserApiController and Api/V1/UserController.
 */
class UserService
{
    /**
     * Get all users
     */
    public function getAllUsers(): array
    {
        return User::all();
    }

    /**
     * Get user by ID
     */
    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Get user by ID or throw exception
     */
    public function findOrFail(int $id): User
    {
        $user = User::find($id);

        if (!$user) {
            throw new \RuntimeException('User not found', 404);
        }

        return $user;
    }

    /**
     * Create new user
     *
     * @param array $data User data (name, email, password)
     * @return User Created user
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // Auto-hashed by User model
        ]);
    }

    /**
     * Update user
     *
     * @param int $id User ID
     * @param array $data Updated data
     * @return User|null Updated user or null if not found
     */
    public function updateUser(int $id, array $data): ?User
    {
        $user = User::find($id);
        if (!$user) {
            return null;
        }

        // Update allowed fields
        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        // Update password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $user->password = $data['password']; // Auto-hashed by User model
        }

        $user->save();

        return $user;
    }

    /**
     * Delete user
     *
     * @param int $id User ID
     * @return bool Success
     */
    public function deleteUser(int $id): bool
    {
        $user = User::find($id);
        if (!$user) {
            return false;
        }

        return $user->delete();
    }

    /**
     * Check if requesting user can access target user's data
     *
     * Implements authorization logic to prevent IDOR vulnerabilities.
     *
     * @param int $targetUserId User being accessed
     * @param int $requestingUserId User making the request
     * @param bool $adminOverride Allow admin access (if role system exists)
     * @return bool Can access
     */
    public function canAccessUser(int $targetUserId, int $requestingUserId, bool $adminOverride = false): bool
    {
        // Users can always access their own data
        if ($targetUserId === $requestingUserId) {
            return true;
        }

        // Optional: Admin override (if you implement role system)
        if ($adminOverride) {
            $requestingUser = User::find($requestingUserId);
            if ($requestingUser && method_exists($requestingUser, 'isAdmin') && $requestingUser->isAdmin()) {
                return true;
            }
        }

        // By default, users cannot access other users' data
        return false;
    }

    /**
     * Check if requesting user can modify target user
     *
     * @param int $targetUserId User being modified
     * @param int $requestingUserId User making the request
     * @return bool Can modify
     */
    public function canModifyUser(int $targetUserId, int $requestingUserId): bool
    {
        // For now, same logic as canAccessUser
        // Can be extended with different permissions (e.g., managers can modify employees)
        return $this->canAccessUser($targetUserId, $requestingUserId, true);
    }

    /**
     * Check if requesting user can delete target user
     *
     * @param int $targetUserId User being deleted
     * @param int $requestingUserId User making the request
     * @return bool Can delete
     */
    public function canDeleteUser(int $targetUserId, int $requestingUserId): bool
    {
        // Cannot delete yourself
        if ($targetUserId === $requestingUserId) {
            return false;
        }

        // Need admin privileges to delete users
        $requestingUser = User::find($requestingUserId);
        if ($requestingUser && method_exists($requestingUser, 'isAdmin') && $requestingUser->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Transform user to array for API response
     *
     * @param User $user
     * @param bool $includeTimestamps Include timestamps
     * @return array
     */
    public function toArray(User $user, bool $includeTimestamps = true): array
    {
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        if ($includeTimestamps) {
            // Use framework accessor methods (works regardless of actual column names)
            $data['created_at'] = $user->getCreatedAt();
            $data['updated_at'] = $user->getUpdatedAt();
        }

        return $data;
    }
}
