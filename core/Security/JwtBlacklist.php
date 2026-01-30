<?php

namespace Core\Security;

use Core\Cache\CacheManager;

/**
 * JWT Token Blacklist / Revocation
 *
 * Manages blacklisted (revoked) JWT tokens using the framework's cache system.
 * Supports both individual token revocation via JTI and bulk user-level
 * invalidation via a "revoked before" timestamp.
 *
 * Cache keys used:
 *   - jwt_blacklist:{jti}          => true          (individual token revocation)
 *   - jwt_user_revoked:{userId}    => timestamp     (user-level invalidation)
 *
 * Usage:
 *   $blacklist = new JwtBlacklist();
 *   $blacklist->add($jti, $expiresAt);
 *   $blacklist->isBlacklisted($jti);
 *   $blacklist->invalidateUser($userId);
 *   $blacklist->isUserInvalidated($userId, $issuedAt);
 */
class JwtBlacklist
{
    /**
     * Cache key prefix for individual blacklisted tokens
     */
    protected const TOKEN_PREFIX = 'jwt_blacklist:';

    /**
     * Cache key prefix for user-level revocation timestamps
     */
    protected const USER_PREFIX = 'jwt_user_revoked:';

    /**
     * Grace period in seconds after blacklisting during which
     * tokens are still accepted (to handle in-flight requests)
     */
    protected int $gracePeriod;

    /**
     * Whether the blacklist feature is enabled
     */
    protected bool $enabled;

    /**
     * Constructor
     *
     * Reads configuration from security.jwt.blacklist_enabled and
     * security.jwt.blacklist_grace_period. Defaults to enabled with
     * a 30-second grace period.
     */
    public function __construct()
    {
        $this->enabled = (bool) config('security.jwt.blacklist_enabled', true);
        $this->gracePeriod = (int) config('security.jwt.blacklist_grace_period', 30);
    }

    /**
     * Add a token to the blacklist
     *
     * The token is stored in cache until its natural expiry time so that
     * we never accumulate stale entries. If the token has no expiry, a
     * fallback TTL of 24 hours is used.
     *
     * @param string $jti       The unique JWT ID claim
     * @param int    $expiresAt The token's exp timestamp (0 = no expiry)
     * @return void
     */
    public function add(string $jti, int $expiresAt): void
    {
        if (!$this->enabled) {
            return;
        }

        $cache = $this->getCache();
        if ($cache === null) {
            return;
        }

        // Calculate TTL: time remaining until the token's natural expiry.
        // If the token has no expiry, use 24 hours as a safe upper bound.
        $ttl = $expiresAt > 0
            ? max($expiresAt - time(), 0)
            : 86400;

        $cache->put(self::TOKEN_PREFIX . $jti, true, $ttl);
    }

    /**
     * Check whether a token JTI has been blacklisted
     *
     * @param string $jti The unique JWT ID claim
     * @return bool True if the token is revoked
     */
    public function isBlacklisted(string $jti): bool
    {
        if (!$this->enabled) {
            return false;
        }

        $cache = $this->getCache();
        if ($cache === null) {
            return false;
        }

        return $cache->has(self::TOKEN_PREFIX . $jti);
    }

    /**
     * Invalidate all tokens for a specific user
     *
     * Stores the current timestamp so that any token with an iat (issued at)
     * before this timestamp will be considered revoked. The cache entry lives
     * for the configured JWT TTL (or 24 hours by default) so it automatically
     * expires once all previously-issued tokens would have expired anyway.
     *
     * @param int $userId The user ID whose tokens should be invalidated
     * @return void
     */
    public function invalidateUser(int $userId): void
    {
        if (!$this->enabled) {
            return;
        }

        $cache = $this->getCache();
        if ($cache === null) {
            return;
        }

        // Store for the maximum token lifetime so all existing tokens
        // are covered. Uses the configured JWT TTL or 24h as fallback.
        $ttl = (int) config('security.jwt.ttl', 3600);
        $ttl = max($ttl, 3600); // at least 1 hour

        $cache->put(self::USER_PREFIX . $userId, time(), $ttl);
    }

    /**
     * Check whether a user's tokens have been bulk-invalidated
     *
     * Compares the token's issued-at timestamp with the stored revocation
     * timestamp. If the token was issued before the user was invalidated
     * (accounting for the grace period), it is considered revoked.
     *
     * @param int $userId  The user ID from the token payload
     * @param int $issuedAt The iat claim from the token
     * @return bool True if the token was issued before the user was invalidated
     */
    public function isUserInvalidated(int $userId, int $issuedAt): bool
    {
        if (!$this->enabled) {
            return false;
        }

        $cache = $this->getCache();
        if ($cache === null) {
            return false;
        }

        $revokedAt = $cache->get(self::USER_PREFIX . $userId);

        if ($revokedAt === null) {
            return false;
        }

        // The token is invalid if it was issued before the revocation
        // timestamp, minus the grace period to handle in-flight requests.
        return $issuedAt < ($revokedAt - $this->gracePeriod);
    }

    /**
     * Get the cache store instance
     *
     * Returns null if the cache system is not available, allowing all
     * blacklist operations to degrade gracefully (tokens are accepted).
     *
     * @return \Core\Cache\Repository|null
     */
    protected function getCache(): ?\Core\Cache\Repository
    {
        try {
            $cache = app('cache');

            if ($cache instanceof CacheManager) {
                return $cache->store();
            }

            // If app('cache') already returns a Repository directly
            if ($cache instanceof \Core\Cache\Repository) {
                return $cache;
            }

            return null;
        } catch (\Throwable $e) {
            // Cache not available -- degrade gracefully
            return null;
        }
    }

    /**
     * Check if the blacklist feature is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Get the configured grace period
     *
     * @return int Grace period in seconds
     */
    public function getGracePeriod(): int
    {
        return $this->gracePeriod;
    }
}
