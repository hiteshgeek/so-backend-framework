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
     */
    public function loginViaRememberToken(): bool
    {
        if (!isset($_COOKIE[$this->rememberCookieName])) {
            return false;
        }

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
    }
}
