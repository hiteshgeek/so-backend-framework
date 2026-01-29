<?php

namespace Core\Cache\Drivers;

/**
 * Array Cache Driver
 *
 * Stores cache in memory for current request only
 */
class ArrayCache
{
    protected array $storage = [];

    public function get(string $key)
    {
        if (!isset($this->storage[$key])) {
            return null;
        }

        $item = $this->storage[$key];

        if ($item['expiration'] !== null && $item['expiration'] < time()) {
            unset($this->storage[$key]);
            return null;
        }

        return $item['value'];
    }

    public function put(string $key, $value, int $seconds): bool
    {
        $this->storage[$key] = [
            'value' => $value,
            'expiration' => $seconds ? time() + $seconds : null,
        ];

        return true;
    }

    public function forever(string $key, $value): bool
    {
        $this->storage[$key] = [
            'value' => $value,
            'expiration' => null,
        ];

        return true;
    }

    public function forget(string $key): bool
    {
        unset($this->storage[$key]);
        return true;
    }

    public function flush(): bool
    {
        $this->storage = [];
        return true;
    }

    public function increment(string $key, int $value = 1): int
    {
        $current = (int)$this->get($key);
        $new = $current + $value;
        $this->forever($key, $new);
        return $new;
    }

    public function decrement(string $key, int $value = 1): int
    {
        return $this->increment($key, -$value);
    }
}
