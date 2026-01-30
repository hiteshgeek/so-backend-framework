<?php

namespace Core\Security;

use Core\Exceptions\EncryptionException;

/**
 * Encrypter
 *
 * Provides AES-256-CBC encryption with HMAC-SHA256 tamper detection.
 * Uses the encrypt-then-MAC approach: the HMAC covers the IV + ciphertext
 * together, ensuring both integrity and authenticity of the encrypted data.
 *
 * Payload format (JSON envelope):
 *   {
 *     "iv":   "<base64-encoded IV>",
 *     "value": "<base64-encoded ciphertext>",
 *     "mac":  "<hex HMAC-SHA256 of iv + value>"
 *   }
 *
 * The entire JSON envelope is then base64-encoded for safe storage.
 *
 * Usage:
 *   $encrypter = new Encrypter($key);
 *   $encrypted = $encrypter->encrypt('sensitive data');
 *   $decrypted = $encrypter->decrypt($encrypted);
 */
class Encrypter
{
    /**
     * The cipher algorithm
     */
    protected const CIPHER = 'aes-256-cbc';

    /**
     * The HMAC hashing algorithm
     */
    protected const HMAC_ALGO = 'sha256';

    /**
     * Required key length in bytes for AES-256
     */
    protected const KEY_LENGTH = 32;

    /**
     * The encryption key
     *
     * @var string
     */
    protected string $key;

    /**
     * Create a new Encrypter instance.
     *
     * Validates the key is present and meets the minimum length requirement
     * for AES-256-CBC (32 bytes).
     *
     * @param string $key The encryption key
     * @throws EncryptionException If the key is missing or too short
     */
    public function __construct(string $key)
    {
        if (empty($key)) {
            throw EncryptionException::missingKey();
        }

        // If key is base64-encoded (prefixed with "base64:"), decode it
        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7), true);

            if ($key === false) {
                throw EncryptionException::missingKey();
            }
        }

        if (strlen($key) < self::KEY_LENGTH) {
            throw EncryptionException::invalidKeyLength(self::KEY_LENGTH);
        }

        // Use exactly 32 bytes for AES-256
        $this->key = substr($key, 0, self::KEY_LENGTH);
    }

    /**
     * Encrypt the given data.
     *
     * Generates a random IV, encrypts with AES-256-CBC, then produces
     * an HMAC-SHA256 over the IV and ciphertext (encrypt-then-MAC).
     * Returns a base64-encoded JSON envelope.
     *
     * @param string $data The plaintext data to encrypt
     * @return string The base64-encoded encrypted payload
     * @throws EncryptionException If encryption fails
     */
    public function encrypt(string $data): string
    {
        // Generate a cryptographically secure random IV (16 bytes for AES-CBC)
        $iv = random_bytes(openssl_cipher_iv_length(self::CIPHER));

        // Encrypt the data
        $ciphertext = openssl_encrypt(
            $data,
            self::CIPHER,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($ciphertext === false) {
            throw new EncryptionException('Failed to encrypt data: ' . openssl_error_string());
        }

        // Base64-encode IV and ciphertext for safe JSON storage
        $ivBase64 = base64_encode($iv);
        $valueBase64 = base64_encode($ciphertext);

        // Generate HMAC over the base64-encoded IV + ciphertext (encrypt-then-MAC)
        $mac = $this->computeHmac($ivBase64, $valueBase64);

        // Build the JSON envelope
        $payload = json_encode([
            'iv'    => $ivBase64,
            'value' => $valueBase64,
            'mac'   => $mac,
        ], JSON_THROW_ON_ERROR);

        // Base64-encode the entire envelope for clean storage
        return base64_encode($payload);
    }

    /**
     * Decrypt the given encrypted payload.
     *
     * Decodes the base64 envelope, verifies the HMAC-SHA256 signature,
     * then decrypts the ciphertext. If the HMAC does not match, the data
     * is considered tampered and an exception is thrown.
     *
     * @param string $encrypted The base64-encoded encrypted payload
     * @return string The decrypted plaintext data
     * @throws EncryptionException If the payload is invalid, tampered, or decryption fails
     */
    public function decrypt(string $encrypted): string
    {
        // Decode the outer base64 envelope
        $jsonPayload = base64_decode($encrypted, true);

        if ($jsonPayload === false) {
            throw EncryptionException::invalidPayload();
        }

        // Parse the JSON envelope
        $payload = json_decode($jsonPayload, true);

        if (!$this->isValidPayload($payload)) {
            throw EncryptionException::invalidPayload();
        }

        // Verify HMAC before attempting decryption (encrypt-then-MAC)
        $expectedMac = $this->computeHmac($payload['iv'], $payload['value']);

        if (!hash_equals($expectedMac, $payload['mac'])) {
            throw EncryptionException::hmacMismatch();
        }

        // Decode the IV and ciphertext
        $iv = base64_decode($payload['iv'], true);
        $ciphertext = base64_decode($payload['value'], true);

        if ($iv === false || $ciphertext === false) {
            throw EncryptionException::invalidPayload();
        }

        // Decrypt the data
        $decrypted = openssl_decrypt(
            $ciphertext,
            self::CIPHER,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($decrypted === false) {
            throw EncryptionException::decryptionFailed();
        }

        return $decrypted;
    }

    /**
     * Compute HMAC-SHA256 over the IV and ciphertext.
     *
     * The HMAC is computed over the concatenation of the base64-encoded
     * IV and the base64-encoded ciphertext, binding both to the MAC.
     *
     * @param string $iv The base64-encoded IV
     * @param string $value The base64-encoded ciphertext
     * @return string Hex-encoded HMAC
     */
    protected function computeHmac(string $iv, string $value): string
    {
        return hash_hmac(self::HMAC_ALGO, $iv . $value, $this->key);
    }

    /**
     * Validate that a decoded payload has the required structure.
     *
     * @param mixed $payload The decoded JSON payload
     * @return bool True if the payload structure is valid
     */
    protected function isValidPayload(mixed $payload): bool
    {
        if (!is_array($payload)) {
            return false;
        }

        // All three fields must be present and non-empty strings
        foreach (['iv', 'value', 'mac'] as $field) {
            if (!isset($payload[$field]) || !is_string($payload[$field]) || $payload[$field] === '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the encryption key length in bytes.
     *
     * @return int
     */
    public static function getKeyLength(): int
    {
        return self::KEY_LENGTH;
    }

    /**
     * Generate a new random encryption key.
     *
     * Useful for key generation commands.
     *
     * @return string A base64-encoded random key
     */
    public static function generateKey(): string
    {
        return 'base64:' . base64_encode(random_bytes(self::KEY_LENGTH));
    }
}
