<?php

namespace Core\Http;

/**
 * Session Management
 *
 * Provides secure session management with hijacking detection.
 */
class Session
{
    protected bool $started = false;

    /**
     * Enable IP validation for hijacking detection
     */
    protected bool $validateIp = true;

    /**
     * Enable User-Agent validation for hijacking detection
     */
    protected bool $validateUserAgent = true;

    /**
     * Interval in seconds for automatic session regeneration
     * Set to 0 to disable automatic regeneration
     */
    protected int $regenerateInterval = 300; // 5 minutes

    /**
     * Maximum concurrent sessions per user (0 = unlimited)
     */
    protected int $maxConcurrentSessions = 0;

    /**
     * Session fingerprint key names
     */
    protected const FINGERPRINT_IP = '_session_ip';
    protected const FINGERPRINT_UA = '_session_ua_hash';
    protected const FINGERPRINT_TIME = '_session_regenerated_at';
    protected const FINGERPRINT_USER = '_session_user_id';

    /**
     * Configure session security settings
     *
     * @param array $config Configuration options
     * @return self
     */
    public function configure(array $config): self
    {
        if (isset($config['validate_ip'])) {
            $this->validateIp = (bool) $config['validate_ip'];
        }
        if (isset($config['validate_user_agent'])) {
            $this->validateUserAgent = (bool) $config['validate_user_agent'];
        }
        if (isset($config['regenerate_interval'])) {
            $this->regenerateInterval = (int) $config['regenerate_interval'];
        }
        if (isset($config['max_concurrent_sessions'])) {
            $this->maxConcurrentSessions = (int) $config['max_concurrent_sessions'];
        }

        return $this;
    }

    public function start(): void
    {
        if ($this->started || session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        // Don't start session if headers already sent (e.g., in tests with output)
        if (headers_sent()) {
            // In test/CLI environment, ensure $_SESSION is available
            if (!isset($_SESSION)) {
                $_SESSION = [];
            }
            $this->started = true;
            return;
        }

        session_start();
        $this->started = true;

        // Validate session security
        if (!$this->validateSession()) {
            // Session failed validation - possible hijacking attempt
            $this->invalidate();
            session_start();
            $this->initializeFingerprint();
        } else {
            // Check if session ID should be regenerated
            $this->checkRegenerationInterval();
        }
    }

    /**
     * Validate session against hijacking attempts
     *
     * @return bool True if session is valid, false if potentially hijacked
     */
    public function validateSession(): bool
    {
        // New session - no validation needed yet
        if (!isset($_SESSION[self::FINGERPRINT_IP]) && !isset($_SESSION[self::FINGERPRINT_UA])) {
            $this->initializeFingerprint();
            return true;
        }

        // Validate IP address
        if ($this->validateIp && !$this->checkIpFingerprint()) {
            return false;
        }

        // Validate User-Agent
        if ($this->validateUserAgent && !$this->checkUserAgentFingerprint()) {
            return false;
        }

        return true;
    }

    /**
     * Initialize session fingerprint for security tracking
     */
    protected function initializeFingerprint(): void
    {
        if ($this->validateIp) {
            $_SESSION[self::FINGERPRINT_IP] = $this->getClientIp();
        }

        if ($this->validateUserAgent) {
            $_SESSION[self::FINGERPRINT_UA] = $this->getUserAgentHash();
        }

        $_SESSION[self::FINGERPRINT_TIME] = time();
    }

    /**
     * Check IP address fingerprint
     *
     * @return bool
     */
    protected function checkIpFingerprint(): bool
    {
        $storedIp = $_SESSION[self::FINGERPRINT_IP] ?? null;

        if ($storedIp === null) {
            return true; // No IP stored yet
        }

        return $storedIp === $this->getClientIp();
    }

    /**
     * Check User-Agent fingerprint
     *
     * @return bool
     */
    protected function checkUserAgentFingerprint(): bool
    {
        $storedHash = $_SESSION[self::FINGERPRINT_UA] ?? null;

        if ($storedHash === null) {
            return true; // No UA stored yet
        }

        return $storedHash === $this->getUserAgentHash();
    }

    /**
     * Check if session ID should be regenerated based on interval
     */
    protected function checkRegenerationInterval(): void
    {
        if ($this->regenerateInterval <= 0) {
            return;
        }

        $lastRegenerated = $_SESSION[self::FINGERPRINT_TIME] ?? 0;
        $timeSinceRegeneration = time() - $lastRegenerated;

        if ($timeSinceRegeneration > $this->regenerateInterval) {
            $this->regenerate();
            $_SESSION[self::FINGERPRINT_TIME] = time();
        }
    }

    /**
     * Get client IP address
     *
     * @return string
     */
    protected function getClientIp(): string
    {
        // Check for proxied IP addresses
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                // Handle comma-separated IPs (from proxies)
                if (str_contains($ip, ',')) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return '0.0.0.0';
    }

    /**
     * Get hashed User-Agent string
     *
     * @return string
     */
    protected function getUserAgentHash(): string
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        return hash('sha256', $userAgent);
    }

    /**
     * Associate a user ID with the session for concurrent session tracking
     *
     * @param int|string $userId
     * @return void
     */
    public function setUserId(int|string $userId): void
    {
        $this->start();
        $_SESSION[self::FINGERPRINT_USER] = $userId;
    }

    /**
     * Get the user ID associated with this session
     *
     * @return int|string|null
     */
    public function getUserId(): int|string|null
    {
        $this->start();
        return $_SESSION[self::FINGERPRINT_USER] ?? null;
    }

    /**
     * Get the current session ID
     *
     * @return string
     */
    public function getId(): string
    {
        $this->start();
        return session_id() ?: '';
    }

    /**
     * Set a custom session ID (must be called before start)
     *
     * @param string $id
     * @return void
     */
    public function setId(string $id): void
    {
        if (!$this->started && session_status() !== PHP_SESSION_ACTIVE) {
            session_id($id);
        }
    }

    /**
     * Get session security metadata
     *
     * @return array
     */
    public function getSecurityMetadata(): array
    {
        $this->start();

        return [
            'ip' => $_SESSION[self::FINGERPRINT_IP] ?? null,
            'user_agent_hash' => $_SESSION[self::FINGERPRINT_UA] ?? null,
            'last_regenerated' => $_SESSION[self::FINGERPRINT_TIME] ?? null,
            'user_id' => $_SESSION[self::FINGERPRINT_USER] ?? null,
            'session_id' => $this->getId(),
        ];
    }

    /**
     * Enable or disable IP validation
     *
     * @param bool $enabled
     * @return self
     */
    public function enableIpValidation(bool $enabled = true): self
    {
        $this->validateIp = $enabled;
        return $this;
    }

    /**
     * Enable or disable User-Agent validation
     *
     * @param bool $enabled
     * @return self
     */
    public function enableUserAgentValidation(bool $enabled = true): self
    {
        $this->validateUserAgent = $enabled;
        return $this;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $this->start();
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $this->start();
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        $this->start();
        return isset($_SESSION[$key]);
    }

    public function forget(string $key): void
    {
        $this->start();
        unset($_SESSION[$key]);
    }

    public function flush(): void
    {
        $this->start();
        $_SESSION = [];
    }

    public function flash(string $key, mixed $value): void
    {
        $this->set($key, $value);
        $this->set('_flash.new', array_merge($this->get('_flash.new', []), [$key]));
    }

    public function flashInput(array $input): void
    {
        $this->flash('_old_input', $input);
    }

    public function getOld(string $key, mixed $default = null): mixed
    {
        $oldInput = $this->get('_old_input', []);
        return $oldInput[$key] ?? $default;
    }

    public function regenerate(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
            session_regenerate_id(true);
        }
    }

    public function invalidate(): void
    {
        $this->flush();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $this->started = false;
    }

    /**
     * Age the flash data for the next request
     */
    public function ageFlashData(): void
    {
        // Get old flash keys and remove them
        $old = $this->get('_flash.old', []);
        foreach ($old as $key) {
            $this->forget($key);
        }

        // Move new flash to old
        $new = $this->get('_flash.new', []);
        $this->set('_flash.old', $new);
        $this->set('_flash.new', []);
    }
}
