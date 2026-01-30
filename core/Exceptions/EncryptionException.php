<?php

namespace Core\Exceptions;

use Exception;

/**
 * Encryption Exception
 *
 * Thrown when encryption or decryption operations fail,
 * including missing keys, tampered payloads, or invalid data.
 */
class EncryptionException extends Exception
{
    /**
     * Create an exception for a missing application key.
     *
     * @return static
     */
    public static function missingKey(): static
    {
        return new static(
            'No application encryption key has been specified. Set the APP_KEY environment variable.'
        );
    }

    /**
     * Create an exception for an insufficient key length.
     *
     * @param int $required The minimum required key length in bytes
     * @return static
     */
    public static function invalidKeyLength(int $required): static
    {
        return new static(
            "The application encryption key must be at least {$required} bytes long."
        );
    }

    /**
     * Create an exception for a tampered or corrupted payload.
     *
     * @return static
     */
    public static function invalidPayload(): static
    {
        return new static(
            'The payload is invalid or has been tampered with.'
        );
    }

    /**
     * Create an exception for an HMAC verification failure.
     *
     * @return static
     */
    public static function hmacMismatch(): static
    {
        return new static(
            'HMAC verification failed. The encrypted data may have been tampered with.'
        );
    }

    /**
     * Create an exception for a decryption failure.
     *
     * @return static
     */
    public static function decryptionFailed(): static
    {
        return new static(
            'Could not decrypt the data. The key may be incorrect or the data may be corrupted.'
        );
    }
}
