<?php

namespace Core\Auth;

use Core\Http\Session;
use Core\Security\Csrf;
use Core\Exceptions\AuthenticationException;
use App\Models\User;

/**
 * Authentication Service
 *
 * Manages user authentication state using sessions with brute force protection
 */
class Auth
{
    protected Session $session;
    protected ?LoginThrottle $throttle = null;
    protected string $sessionKey = 'auth_user_id';
    protected string $rememberCookieName = 'remember_token';
    protected int $rememberDuration = 2592000; // 30 days in seconds
    protected bool $secureCookie;
    protected string $cookieDomain;

    public function __construct(Session $session, ?LoginThrottle $throttle = null)
    {
        $this->session = $session;
        $this->throttle = $throttle;
        $this->secureCookie = (bool) ($_ENV['COOKIE_SECURE'] ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'));
        $this->cookieDomain = $_ENV['COOKIE_DOMAIN'] ?? '';
    }

    /**
     * Attempt to authenticate user with credentials
     *
     * @param array $credentials Must contain 'email' and 'password'
     * @param bool $remember Enable "remember me" functionality
     * @return bool True if authentication successful
     * @throws AuthenticationException If account is locked out
     */
    public function attempt(array $credentials, bool $remember = false): bool
    {
        if (!isset($credentials['email']) || !isset($credentials['password'])) {
            return false;
        }

        $email = $credentials['email'];
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        // Check if account is locked out due to too many failed attempts
        if ($this->throttle && $this->throttle->isAvailable()) {
            $throttleKey = LoginThrottle::key($ip, $email);

            if ($this->throttle->tooManyAttempts($throttleKey)) {
                $seconds = $this->throttle->lockoutSeconds($throttleKey);
                $minutes = ceil($seconds / 60);

                throw AuthenticationException::accountLocked($minutes);
            }
        }

        $user = User::findByEmail($email);

        if ($user && $user->verifyPassword($credentials['password'])) {
            // Clear login attempts on successful authentication
            if ($this->throttle && $this->throttle->isAvailable()) {
                $throttleKey = LoginThrottle::key($ip, $email);
                $this->throttle->clear($throttleKey);
            }

            $this->login($user, $remember);
            return true;
        }

        // Increment failed attempts counter
        if ($this->throttle && $this->throttle->isAvailable()) {
            $throttleKey = LoginThrottle::key($ip, $email);
            $this->throttle->attempt($throttleKey);
        }

        return false;
    }

    /**
     * Log a user into the application
     */
    public function login(User $user, bool $remember = false): void
    {
        // Regenerate session ID to prevent session fixation
        $this->session->regenerate();

        // Regenerate CSRF token on login for security
        Csrf::regenerate();

        error_log("Auth->login() - User ID: " . var_export($user->id, true) . ", UID: " . var_export($user->uid, true));
        $this->session->set($this->sessionKey, $user->id);
        error_log("Auth->login() - Session after set: " . var_export($this->session->get($this->sessionKey), true));

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
        // Note: auser table doesn't have remember_token column, so skip this
        $user = $this->user();
        if ($user && property_exists($user, 'remember_token')) {
            try {
                $user->remember_token = null;
                $user->save();
            } catch (\Exception $e) {
                // Ignore if remember_token column doesn't exist
                error_log("Could not clear remember token: " . $e->getMessage());
            }
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
     * Note: Skipped for auser table as it doesn't have remember_token column
     */
    protected function setRememberToken(User $user): void
    {
        // auser table doesn't support remember tokens, skip this
        if (!property_exists($user, 'remember_token')) {
            return;
        }

        $token = bin2hex(random_bytes(32));

        try {
            // Save hashed token to database for security
            $user->remember_token = hash('sha256', $token);
            $user->save();

            // Set cookie with raw token (user presents this to authenticate)
            setcookie(
                $this->rememberCookieName,
                $token,
                time() + $this->rememberDuration,
                '/',
                $this->cookieDomain,
                $this->secureCookie,
                true   // HTTP only
            );
        } catch (\Exception $e) {
            error_log("Could not set remember token: " . $e->getMessage());
        }
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
            $this->cookieDomain,
            $this->secureCookie,
            true
        );
    }

    /**
     * Attempt to authenticate user via remember token
     * Note: Not supported for auser table (no remember_token column)
     */
    public function loginViaRememberToken(): bool
    {
        if (!isset($_COOKIE[$this->rememberCookieName])) {
            return false;
        }

        try {
            $token = $_COOKIE[$this->rememberCookieName];
            $hashedToken = hash('sha256', $token);

            // Find user by hashed remember token
            $result = User::where('remember_token', '=', $hashedToken)->first();

            if ($result) {
                $user = new User($result);
                $user->exists = true;
                $user->original = $result;
                $this->login($user, true); // Refresh the remember token
                return true;
            }

            // Token not valid, clear cookie
            $this->clearRememberCookie();
            return false;
        } catch (\Exception $e) {
            // Remember token not supported for this user table
            error_log("Remember token login failed: " . $e->getMessage());
            $this->clearRememberCookie();
            return false;
        }
    }
}
