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
    protected string $rememberCookieName = 'remember_token';
    protected int $rememberDuration = 2592000; // 30 days in seconds

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Attempt to authenticate user with credentials
     */
    public function attempt(array $credentials, bool $remember = false): bool
    {
        if (!isset($credentials['email']) || !isset($credentials['password'])) {
            return false;
        }

        $user = User::findByEmail($credentials['email']);

        if ($user && $user->verifyPassword($credentials['password'])) {
            $this->login($user, $remember);
            return true;
        }

        return false;
    }

    /**
     * Log a user into the application
     */
    public function login(User $user, bool $remember = false): void
    {
        $this->session->set($this->sessionKey, $user->id);

        if ($remember) {
            $this->setRememberToken($user);
        }
    }

    /**
     * Log the user out of the application
     */
    public function logout(): void
    {
        // Clear remember token from database if user is logged in
        $user = $this->user();
        if ($user) {
            $user->remember_token = null;
            $user->save();
        }

        $this->session->forget($this->sessionKey);
        $this->session->regenerate();

        // Clear remember cookie
        $this->clearRememberCookie();
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

    /**
     * Generate and set a remember token for the user
     */
    protected function setRememberToken(User $user): void
    {
        $token = bin2hex(random_bytes(32));

        // Save token to database
        $user->remember_token = $token;
        $user->save();

        // Set cookie
        setcookie(
            $this->rememberCookieName,
            $token,
            time() + $this->rememberDuration,
            '/',
            '',
            false, // Set to true in production with HTTPS
            true   // HTTP only
        );
    }

    /**
     * Clear the remember cookie
     */
    protected function clearRememberCookie(): void
    {
        setcookie(
            $this->rememberCookieName,
            '',
            time() - 3600,
            '/',
            '',
            false,
            true
        );
    }

    /**
     * Attempt to authenticate user via remember token
     */
    public function loginViaRememberToken(): bool
    {
        if (!isset($_COOKIE[$this->rememberCookieName])) {
            return false;
        }

        $token = $_COOKIE[$this->rememberCookieName];

        // Find user by remember token
        $user = User::where('remember_token', '=', $token)->first();

        if ($user) {
            $this->login($user, true); // Refresh the remember token
            return true;
        }

        // Token not valid, clear cookie
        $this->clearRememberCookie();
        return false;
    }
}
