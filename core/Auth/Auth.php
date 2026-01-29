<?php

namespace Core\Auth;

use Core\Http\Session;
use App\Models\User;

/**
 * Authentication Service
 *
 * Manages user authentication state using sessions
 */
class Auth
{
    protected Session $session;
    protected string $sessionKey = 'auth_user_id';

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Attempt to authenticate user with credentials
     */
    public function attempt(array $credentials): bool
    {
        if (!isset($credentials['email']) || !isset($credentials['password'])) {
            return false;
        }

        $user = User::findByEmail($credentials['email']);

        if ($user && $user->verifyPassword($credentials['password'])) {
            $this->login($user);
            return true;
        }

        return false;
    }

    /**
     * Log a user into the application
     */
    public function login(User $user): void
    {
        $this->session->set($this->sessionKey, $user->id);
    }

    /**
     * Log the user out of the application
     */
    public function logout(): void
    {
        $this->session->forget($this->sessionKey);
        $this->session->regenerate();
    }

    /**
     * Check if a user is authenticated
     */
    public function check(): bool
    {
        return $this->session->has($this->sessionKey);
    }

    /**
     * Check if a user is a guest (not authenticated)
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user
     */
    public function user(): ?User
    {
        if (!$this->check()) {
            return null;
        }

        $userId = $this->session->get($this->sessionKey);
        return User::find($userId);
    }

    /**
     * Get the ID of the currently authenticated user
     */
    public function id(): ?int
    {
        return $this->session->get($this->sessionKey);
    }
}
