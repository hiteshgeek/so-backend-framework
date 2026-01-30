<?php

namespace Core\Http;

/**
 * Session Management
 */
class Session
{
    protected bool $started = false;

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
