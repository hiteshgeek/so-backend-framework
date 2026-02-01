<?php

namespace Core\Auth\TwoFactor;

/**
 * TOTP (Time-based One-Time Password) Authenticator
 *
 * Implements RFC 6238 TOTP algorithm for two-factor authentication.
 * Compatible with Google Authenticator, Authy, and similar apps.
 *
 * Usage:
 *   $totp = new TotpAuthenticator();
 *
 *   // Generate secret for new user
 *   $secret = $totp->generateSecret();
 *
 *   // Generate QR code URL for authenticator app
 *   $qrUrl = $totp->getQrCodeUrl($secret, 'user@example.com', 'MyApp');
 *
 *   // Verify code from user
 *   if ($totp->verify($secret, $userCode)) {
 *       // Code is valid
 *   }
 */
class TotpAuthenticator
{
    /**
     * Number of digits in the OTP code
     */
    protected int $digits = 6;

    /**
     * Time step in seconds
     */
    protected int $period = 30;

    /**
     * Hash algorithm to use
     */
    protected string $algorithm = 'sha1';

    /**
     * Secret key length in bytes
     */
    protected int $secretLength = 20;

    /**
     * Base32 alphabet for encoding/decoding
     */
    protected const BASE32_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     * Configure the authenticator
     *
     * @param array $config Configuration options
     * @return self
     */
    public function configure(array $config): self
    {
        if (isset($config['digits'])) {
            $this->digits = (int) $config['digits'];
        }
        if (isset($config['period'])) {
            $this->period = (int) $config['period'];
        }
        if (isset($config['algorithm'])) {
            $this->algorithm = $config['algorithm'];
        }
        if (isset($config['secret_length'])) {
            $this->secretLength = (int) $config['secret_length'];
        }

        return $this;
    }

    /**
     * Generate a new random secret key
     *
     * @param int|null $length Secret length in bytes (null = use default)
     * @return string Base32 encoded secret
     */
    public function generateSecret(?int $length = null): string
    {
        $length = $length ?? $this->secretLength;
        $randomBytes = random_bytes($length);

        return $this->base32Encode($randomBytes);
    }

    /**
     * Get the current TOTP code
     *
     * @param string $secret Base32 encoded secret
     * @param int|null $timestamp Unix timestamp (null = current time)
     * @return string The OTP code
     */
    public function getCode(string $secret, ?int $timestamp = null): string
    {
        $timestamp = $timestamp ?? time();
        $counter = (int) floor($timestamp / $this->period);

        return $this->generateHotp($secret, $counter);
    }

    /**
     * Verify a TOTP code
     *
     * @param string $secret Base32 encoded secret
     * @param string $code Code to verify
     * @param int $window Number of periods to check before/after current (default: 1)
     * @return bool True if code is valid
     */
    public function verify(string $secret, string $code, int $window = 1): bool
    {
        $timestamp = time();

        // Check current period and adjacent periods within window
        for ($i = -$window; $i <= $window; $i++) {
            $checkTime = $timestamp + ($i * $this->period);
            $expectedCode = $this->getCode($secret, $checkTime);

            if (hash_equals($expectedCode, $code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate HOTP (counter-based OTP)
     *
     * @param string $secret Base32 encoded secret
     * @param int $counter Counter value
     * @return string The OTP code
     */
    protected function generateHotp(string $secret, int $counter): string
    {
        // Decode Base32 secret
        $key = $this->base32Decode($secret);

        // Pack counter as 64-bit big-endian
        $counterBytes = pack('N*', 0, $counter);

        // Generate HMAC
        $hash = hash_hmac($this->algorithm, $counterBytes, $key, true);

        // Dynamic truncation
        $offset = ord($hash[strlen($hash) - 1]) & 0x0f;

        $binary = (
            ((ord($hash[$offset]) & 0x7f) << 24) |
            ((ord($hash[$offset + 1]) & 0xff) << 16) |
            ((ord($hash[$offset + 2]) & 0xff) << 8) |
            (ord($hash[$offset + 3]) & 0xff)
        );

        $otp = $binary % pow(10, $this->digits);

        return str_pad((string) $otp, $this->digits, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a URL for QR code (otpauth:// format)
     *
     * @param string $secret Base32 encoded secret
     * @param string $accountName User's email or username
     * @param string $issuer Application name
     * @return string otpauth:// URL
     */
    public function getQrCodeUrl(string $secret, string $accountName, string $issuer): string
    {
        $params = [
            'secret' => $secret,
            'issuer' => $issuer,
            'algorithm' => strtoupper($this->algorithm),
            'digits' => $this->digits,
            'period' => $this->period,
        ];

        return sprintf(
            'otpauth://totp/%s:%s?%s',
            rawurlencode($issuer),
            rawurlencode($accountName),
            http_build_query($params)
        );
    }

    /**
     * Generate a URL for Google Charts QR code API
     *
     * @param string $secret Base32 encoded secret
     * @param string $accountName User's email or username
     * @param string $issuer Application name
     * @param int $size QR code size in pixels
     * @return string URL to QR code image
     */
    public function getQrCodeImageUrl(string $secret, string $accountName, string $issuer, int $size = 200): string
    {
        $otpauthUrl = $this->getQrCodeUrl($secret, $accountName, $issuer);

        return sprintf(
            'https://chart.googleapis.com/chart?chs=%dx%d&chld=M|0&cht=qr&chl=%s',
            $size,
            $size,
            urlencode($otpauthUrl)
        );
    }

    /**
     * Generate backup codes for account recovery
     *
     * @param int $count Number of codes to generate
     * @param int $length Length of each code
     * @return array Array of backup codes
     */
    public function generateBackupCodes(int $count = 8, int $length = 8): array
    {
        $codes = [];

        for ($i = 0; $i < $count; $i++) {
            $code = strtoupper(bin2hex(random_bytes($length / 2)));
            // Format with dash for readability: XXXX-XXXX
            if ($length === 8) {
                $code = substr($code, 0, 4) . '-' . substr($code, 4, 4);
            }
            $codes[] = $code;
        }

        return $codes;
    }

    /**
     * Hash backup codes for storage
     *
     * @param array $codes Backup codes
     * @return array Hashed codes
     */
    public function hashBackupCodes(array $codes): array
    {
        return array_map(function ($code) {
            // Remove dashes for hashing
            $normalized = str_replace('-', '', $code);
            return hash('sha256', $normalized);
        }, $codes);
    }

    /**
     * Verify a backup code against hashed codes
     *
     * @param string $code Code to verify
     * @param array $hashedCodes Array of hashed codes
     * @return int|false Index of matched code or false if not found
     */
    public function verifyBackupCode(string $code, array $hashedCodes): int|false
    {
        $normalized = str_replace('-', '', strtoupper($code));
        $codeHash = hash('sha256', $normalized);

        foreach ($hashedCodes as $index => $hashedCode) {
            if (hash_equals($hashedCode, $codeHash)) {
                return $index;
            }
        }

        return false;
    }

    /**
     * Base32 encode a string
     *
     * @param string $data Raw binary data
     * @return string Base32 encoded string
     */
    protected function base32Encode(string $data): string
    {
        $binary = '';
        foreach (str_split($data) as $char) {
            $binary .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }

        $encoded = '';
        $chunks = str_split($binary, 5);

        foreach ($chunks as $chunk) {
            $chunk = str_pad($chunk, 5, '0', STR_PAD_RIGHT);
            $index = bindec($chunk);
            $encoded .= self::BASE32_ALPHABET[$index];
        }

        // Add padding
        $padding = 8 - (strlen($encoded) % 8);
        if ($padding < 8) {
            $encoded .= str_repeat('=', $padding);
        }

        return $encoded;
    }

    /**
     * Base32 decode a string
     *
     * @param string $data Base32 encoded string
     * @return string Raw binary data
     */
    protected function base32Decode(string $data): string
    {
        // Remove padding
        $data = rtrim(strtoupper($data), '=');

        $binary = '';
        foreach (str_split($data) as $char) {
            $index = strpos(self::BASE32_ALPHABET, $char);
            if ($index === false) {
                continue;
            }
            $binary .= str_pad(decbin($index), 5, '0', STR_PAD_LEFT);
        }

        $decoded = '';
        foreach (str_split($binary, 8) as $byte) {
            if (strlen($byte) === 8) {
                $decoded .= chr(bindec($byte));
            }
        }

        return $decoded;
    }

    /**
     * Get the current time period counter
     *
     * @param int|null $timestamp Unix timestamp (null = current time)
     * @return int Counter value
     */
    public function getCounter(?int $timestamp = null): int
    {
        $timestamp = $timestamp ?? time();
        return (int) floor($timestamp / $this->period);
    }

    /**
     * Get seconds remaining in current period
     *
     * @param int|null $timestamp Unix timestamp (null = current time)
     * @return int Seconds remaining
     */
    public function getSecondsRemaining(?int $timestamp = null): int
    {
        $timestamp = $timestamp ?? time();
        return $this->period - ($timestamp % $this->period);
    }
}
