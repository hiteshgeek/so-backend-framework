<?php

namespace Core\Security;

/**
 * Legacy Password Hasher
 *
 * Handles verification of passwords hashed with the old framework's method:
 * sha1(md5(PASSWORD_SALT) . $password)
 *
 * This class is used during the migration period to:
 * 1. Verify passwords stored in the old format
 * 2. Allow users to login with old passwords
 * 3. Facilitate gradual migration to secure password hashing
 *
 * SECURITY NOTE: This uses weak hashing (SHA1) and should only be used
 * for verification during migration. New passwords should always use
 * PASSWORD_ARGON2ID or PASSWORD_BCRYPT.
 *
 */
class LegacyPasswordHasher
{
    /**
     * The legacy password salt from old framework
     * This matches BaseConfig::PASSWORD_SALT in rapidkartprocessadminv2
     */
    private const PASSWORD_SALT = "K<47`5n9~8H5`*^Ks.>ie5&";

    /**
     * Hash a password using the legacy method
     *
     * WARNING: Only use for verification/migration, never for new passwords
     *
     * @param string $password Plain text password
     * @return string SHA1 hash with salted md5
     */
    public static function hash(string $password): string
    {
        $salt = md5(self::PASSWORD_SALT);
        return sha1($salt . $password);
    }

    /**
     * Verify a password against a legacy hash
     *
     * @param string $password Plain text password to verify
     * @param string $hash The stored legacy hash
     * @return bool True if password matches
     */
    public static function verify(string $password, string $hash): bool
    {
        return hash_equals($hash, self::hash($password));
    }

    /**
     * Check if a hash appears to be in legacy format
     *
     * Legacy format: 40-character SHA1 hex string
     * Modern formats: Start with $2y$ (bcrypt) or $argon2 (argon2id)
     *
     * @param string $hash The hash to check
     * @return bool True if hash is in legacy format
     */
    public static function isLegacyHash(string $hash): bool
    {
        // Modern password_hash formats start with $
        if (str_starts_with($hash, '$')) {
            return false;
        }

        // Legacy SHA1 hash is 40 hex characters
        return strlen($hash) === 40 && ctype_xdigit($hash);
    }

    /**
     * Check if a hash is in modern format (bcrypt or argon2)
     *
     * @param string $hash The hash to check
     * @return bool True if hash is in modern format
     */
    public static function isModernHash(string $hash): bool
    {
        return str_starts_with($hash, '$2y$')      // bcrypt
            || str_starts_with($hash, '$2a$')      // bcrypt (old)
            || str_starts_with($hash, '$2b$')      // bcrypt
            || str_starts_with($hash, '$argon2i$') // argon2i
            || str_starts_with($hash, '$argon2id$'); // argon2id
    }
}
