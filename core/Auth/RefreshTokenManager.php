<?php

namespace Core\Auth;

/**
 * Refresh Token Manager
 *
 * Manages refresh tokens for stateless authentication (JWT).
 * Tokens are stored in cache/database with configurable TTL.
 *
 * Usage:
 *   $manager = new RefreshTokenManager();
 *
 *   // Create refresh token for user
 *   $refreshToken = $manager->create($userId);
 *
 *   // Validate token
 *   $data = $manager->validate($refreshToken);
 *   if ($data) {
 *       $userId = $data['user_id'];
 *   }
 *
 *   // Refresh (rotate) token
 *   $newData = $manager->refresh($oldToken);
 *
 *   // Revoke token
 *   $manager->revoke($refreshToken);
 */
class RefreshTokenManager
{
    /**
     * Cache key prefix for refresh tokens
     */
    protected string $cachePrefix = 'refresh_token:';

    /**
     * Token TTL in seconds (default: 7 days)
     */
    protected int $ttl = 604800;

    /**
     * Token length in bytes
     */
    protected int $tokenLength = 32;

    /**
     * Whether to use database instead of cache
     */
    protected bool $useDatabase = false;

    /**
     * Database table name for tokens
     */
    protected string $table = 'refresh_tokens';

    /**
     * Maximum tokens per user (0 = unlimited)
     */
    protected int $maxTokensPerUser = 5;

    /**
     * Configure the manager
     *
     * @param array $config Configuration options
     * @return self
     */
    public function configure(array $config): self
    {
        if (isset($config['cache_prefix'])) {
            $this->cachePrefix = $config['cache_prefix'];
        }
        if (isset($config['ttl'])) {
            $this->ttl = (int) $config['ttl'];
        }
        if (isset($config['token_length'])) {
            $this->tokenLength = (int) $config['token_length'];
        }
        if (isset($config['use_database'])) {
            $this->useDatabase = (bool) $config['use_database'];
        }
        if (isset($config['table'])) {
            $this->table = $config['table'];
        }
        if (isset($config['max_tokens_per_user'])) {
            $this->maxTokensPerUser = (int) $config['max_tokens_per_user'];
        }

        return $this;
    }

    /**
     * Create a new refresh token for a user
     *
     * @param int|string $userId User ID
     * @param array $metadata Additional metadata to store
     * @return string The raw refresh token
     */
    public function create(int|string $userId, array $metadata = []): string
    {
        // Generate random token
        $token = bin2hex(random_bytes($this->tokenLength));
        $hashedToken = $this->hashToken($token);

        $data = [
            'user_id' => $userId,
            'created_at' => time(),
            'expires_at' => time() + $this->ttl,
            'metadata' => $metadata,
        ];

        // Enforce max tokens per user
        if ($this->maxTokensPerUser > 0) {
            $this->pruneExcessTokens($userId);
        }

        // Store token
        if ($this->useDatabase) {
            $this->storeInDatabase($hashedToken, $data);
        } else {
            $this->storeInCache($hashedToken, $data);
        }

        return $token;
    }

    /**
     * Validate a refresh token
     *
     * @param string $token The raw refresh token
     * @return array|null Token data if valid, null if invalid/expired
     */
    public function validate(string $token): ?array
    {
        $hashedToken = $this->hashToken($token);

        if ($this->useDatabase) {
            $data = $this->getFromDatabase($hashedToken);
        } else {
            $data = $this->getFromCache($hashedToken);
        }

        if (!$data) {
            return null;
        }

        // Check expiration
        if (isset($data['expires_at']) && $data['expires_at'] < time()) {
            $this->revoke($token);
            return null;
        }

        return $data;
    }

    /**
     * Refresh (rotate) a token
     *
     * Revokes the old token and creates a new one.
     *
     * @param string $oldToken The current refresh token
     * @return array|null ['refresh_token' => string, 'user_id' => int] or null if invalid
     */
    public function refresh(string $oldToken): ?array
    {
        $data = $this->validate($oldToken);

        if (!$data) {
            return null;
        }

        // Revoke old token
        $this->revoke($oldToken);

        // Create new token with same metadata
        $newToken = $this->create(
            $data['user_id'],
            $data['metadata'] ?? []
        );

        return [
            'refresh_token' => $newToken,
            'user_id' => $data['user_id'],
            'expires_at' => time() + $this->ttl,
        ];
    }

    /**
     * Revoke a specific token
     *
     * @param string $token The refresh token to revoke
     * @return bool True if token was revoked
     */
    public function revoke(string $token): bool
    {
        $hashedToken = $this->hashToken($token);

        if ($this->useDatabase) {
            return $this->deleteFromDatabase($hashedToken);
        }

        return $this->deleteFromCache($hashedToken);
    }

    /**
     * Revoke all tokens for a user
     *
     * @param int|string $userId User ID
     * @return int Number of tokens revoked
     */
    public function revokeAllForUser(int|string $userId): int
    {
        if ($this->useDatabase) {
            return $this->deleteAllFromDatabaseForUser($userId);
        }

        // Cache-based revocation requires iterating (limited support)
        // For production, use database storage for this feature
        return 0;
    }

    /**
     * Get all active tokens for a user
     *
     * @param int|string $userId User ID
     * @return array Array of token data
     */
    public function getTokensForUser(int|string $userId): array
    {
        if (!$this->useDatabase) {
            return []; // Not supported for cache storage
        }

        try {
            $db = app('db');
            $results = $db->table($this->table)
                ->where('user_id', '=', $userId)
                ->where('expires_at', '>', time())
                ->get();

            return array_map(function ($row) {
                return [
                    'id' => $row['id'],
                    'created_at' => $row['created_at'],
                    'expires_at' => $row['expires_at'],
                    'ip_address' => $row['ip_address'] ?? null,
                    'user_agent' => $row['user_agent'] ?? null,
                ];
            }, $results);
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Clean up expired tokens
     *
     * @return int Number of tokens cleaned
     */
    public function cleanup(): int
    {
        if (!$this->useDatabase) {
            return 0; // Cache handles TTL automatically
        }

        try {
            $db = app('db');
            $count = $db->table($this->table)
                ->where('expires_at', '<', time())
                ->count();

            $db->table($this->table)
                ->where('expires_at', '<', time())
                ->delete();

            return $count;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Hash a token for storage
     *
     * @param string $token Raw token
     * @return string Hashed token
     */
    protected function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    /**
     * Store token in cache
     */
    protected function storeInCache(string $hashedToken, array $data): void
    {
        $cache = app('cache');
        if ($cache) {
            $cache->set($this->cachePrefix . $hashedToken, $data, $this->ttl);
        }
    }

    /**
     * Get token from cache
     */
    protected function getFromCache(string $hashedToken): ?array
    {
        $cache = app('cache');
        if (!$cache) {
            return null;
        }

        return $cache->get($this->cachePrefix . $hashedToken);
    }

    /**
     * Delete token from cache
     */
    protected function deleteFromCache(string $hashedToken): bool
    {
        $cache = app('cache');
        if (!$cache) {
            return false;
        }

        return $cache->delete($this->cachePrefix . $hashedToken);
    }

    /**
     * Store token in database
     */
    protected function storeInDatabase(string $hashedToken, array $data): void
    {
        try {
            $db = app('db');
            $db->table($this->table)->insert([
                'token' => $hashedToken,
                'user_id' => $data['user_id'],
                'created_at' => $data['created_at'],
                'expires_at' => $data['expires_at'],
                'metadata' => json_encode($data['metadata'] ?? []),
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            ]);
        } catch (\Throwable $e) {
            // Log error if logger available
            if (function_exists('logger')) {
                logger()->error('Failed to store refresh token', [
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Get token from database
     */
    protected function getFromDatabase(string $hashedToken): ?array
    {
        try {
            $db = app('db');
            $row = $db->table($this->table)
                ->where('token', '=', $hashedToken)
                ->first();

            if (!$row) {
                return null;
            }

            return [
                'user_id' => $row['user_id'],
                'created_at' => $row['created_at'],
                'expires_at' => $row['expires_at'],
                'metadata' => json_decode($row['metadata'] ?? '{}', true),
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Delete token from database
     */
    protected function deleteFromDatabase(string $hashedToken): bool
    {
        try {
            $db = app('db');
            return $db->table($this->table)
                ->where('token', '=', $hashedToken)
                ->delete();
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Delete all tokens for user from database
     */
    protected function deleteAllFromDatabaseForUser(int|string $userId): int
    {
        try {
            $db = app('db');
            $count = $db->table($this->table)
                ->where('user_id', '=', $userId)
                ->count();

            $db->table($this->table)
                ->where('user_id', '=', $userId)
                ->delete();

            return $count;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Prune excess tokens for a user (keep newest)
     */
    protected function pruneExcessTokens(int|string $userId): void
    {
        if (!$this->useDatabase || $this->maxTokensPerUser <= 0) {
            return;
        }

        try {
            $db = app('db');

            // Get count of existing tokens
            $count = $db->table($this->table)
                ->where('user_id', '=', $userId)
                ->count();

            if ($count >= $this->maxTokensPerUser) {
                // Delete oldest tokens to make room
                $toDelete = $count - $this->maxTokensPerUser + 1;

                $oldestTokens = $db->table($this->table)
                    ->select('id')
                    ->where('user_id', '=', $userId)
                    ->orderBy('created_at', 'ASC')
                    ->limit($toDelete)
                    ->get();

                foreach ($oldestTokens as $token) {
                    $db->table($this->table)
                        ->where('id', '=', $token['id'])
                        ->delete();
                }
            }
        } catch (\Throwable $e) {
            // Ignore pruning errors
        }
    }

    /**
     * Get TTL in seconds
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * Set TTL in seconds
     */
    public function setTtl(int $ttl): self
    {
        $this->ttl = $ttl;
        return $this;
    }
}
