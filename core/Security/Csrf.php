<?php

namespace Core\Security;

use Core\Http\Session;

/**
 * CSRF Protection Service
 *
 * Generates and validates CSRF tokens to prevent Cross-Site Request Forgery attacks
 */
class Csrf
{
    protected Session $session;
    protected string $tokenKey = '_csrf_token';

    public function __construct(Session $session)
    {
        $this->session = $session;

        // Auto-generate token if not exists
        if (!$this->session->has($this->tokenKey)) {
            $this->regenerateToken();
        }
    }

    /**
     * Generate a new random CSRF token
     */
    public function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Get the current CSRF token from session
     */
    public function getToken(): ?string
    {
        return $this->session->get($this->tokenKey);
    }

    /**
     * Validate a CSRF token against the session token
     */
    public function validateToken(string $token): bool
    {
        $sessionToken = $this->getToken();

        if (!$sessionToken) {
            return false;
        }

        // Use hash_equals to prevent timing attacks
        return hash_equals($sessionToken, $token);
    }

    /**
     * Generate a new token and store it in the session
     */
    public function regenerateToken(): string
    {
        $token = $this->generateToken();
        $this->session->set($this->tokenKey, $token);
        return $token;
    }
}
