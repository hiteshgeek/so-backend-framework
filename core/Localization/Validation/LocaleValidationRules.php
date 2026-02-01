<?php

namespace Core\Localization\Validation;

/**
 * LocaleValidationRules
 *
 * Provides locale/country-specific validation patterns for phone numbers,
 * postal codes, tax IDs, and other location-specific formats.
 *
 * Usage:
 * ```php
 * // Validate phone number
 * if (LocaleValidationRules::validatePhone('+14155551234', 'US')) {
 *     // Valid US phone number
 * }
 *
 * // Validate postal code
 * if (LocaleValidationRules::validatePostalCode('90210', 'US')) {
 *     // Valid US ZIP code
 * }
 *
 * // Get pattern for custom validation
 * $pattern = LocaleValidationRules::getPhonePattern('DE');
 * ```
 */
class LocaleValidationRules
{
    /**
     * Phone number patterns by country code (ISO 3166-1 alpha-2)
     * Patterns support both local and international formats
     */
    protected static array $phonePatterns = [
        // North America
        'US' => '/^(\+?1)?[2-9]\d{2}[2-9]\d{6}$/', // +1, 1, or no prefix
        'CA' => '/^(\+?1)?[2-9]\d{2}[2-9]\d{6}$/', // Same as US
        'MX' => '/^(\+?52)?[1-9]\d{9,10}$/',

        // Europe
        'DE' => '/^(\+49|0)?[1-9]\d{2,14}$/',      // Germany: +49, 0, or no prefix
        'FR' => '/^(\+33|0)?[1-9]\d{8}$/',         // France: +33, 0, or no prefix
        'GB' => '/^(\+44|0)?[1-9]\d{9,10}$/',      // UK: +44, 0, or no prefix
        'IT' => '/^(\+39)?[0-9]{6,12}$/',          // Italy
        'ES' => '/^(\+34)?[6-9]\d{8}$/',           // Spain
        'NL' => '/^(\+31|0)?[1-9]\d{8}$/',         // Netherlands
        'BE' => '/^(\+32|0)?[1-9]\d{7,8}$/',       // Belgium
        'CH' => '/^(\+41|0)?[1-9]\d{8}$/',         // Switzerland
        'AT' => '/^(\+43|0)?[1-9]\d{3,12}$/',      // Austria
        'PL' => '/^(\+48)?[1-9]\d{8}$/',           // Poland
        'SE' => '/^(\+46|0)?[1-9]\d{6,11}$/',      // Sweden
        'NO' => '/^(\+47)?[2-9]\d{7}$/',           // Norway
        'DK' => '/^(\+45)?[2-9]\d{7}$/',           // Denmark
        'FI' => '/^(\+358|0)?[1-9]\d{4,11}$/',     // Finland
        'PT' => '/^(\+351)?[1-9]\d{8}$/',          // Portugal
        'GR' => '/^(\+30)?[1-9]\d{9}$/',           // Greece
        'IE' => '/^(\+353|0)?[1-9]\d{6,9}$/',      // Ireland

        // Asia
        'IN' => '/^(\+91)?[6-9]\d{9}$/',           // India
        'CN' => '/^(\+86)?1[3-9]\d{9}$/',          // China
        'JP' => '/^(\+81|0)?[1-9]\d{8,9}$/',       // Japan
        'KR' => '/^(\+82|0)?[1-9]\d{7,10}$/',      // South Korea
        'ID' => '/^(\+62|0)?[1-9]\d{8,11}$/',      // Indonesia
        'MY' => '/^(\+60|0)?[1-9]\d{7,9}$/',       // Malaysia
        'SG' => '/^(\+65)?[689]\d{7}$/',           // Singapore
        'TH' => '/^(\+66|0)?[1-9]\d{8}$/',         // Thailand
        'VN' => '/^(\+84|0)?[1-9]\d{8,9}$/',       // Vietnam
        'PH' => '/^(\+63|0)?[1-9]\d{9}$/',         // Philippines
        'PK' => '/^(\+92|0)?[1-9]\d{9}$/',         // Pakistan
        'BD' => '/^(\+880|0)?[1-9]\d{9}$/',        // Bangladesh

        // Middle East
        'AE' => '/^(\+971|0)?[1-9]\d{7,8}$/',      // UAE: +971 or 0 prefix
        'SA' => '/^(\+966|0)?[1-9]\d{8}$/',        // Saudi Arabia: +966 or 0 prefix
        'IL' => '/^(\+972|0)?[1-9]\d{7,8}$/',      // Israel
        'TR' => '/^(\+90|0)?[1-9]\d{9}$/',         // Turkey
        'EG' => '/^(\+20|0)?[1-9]\d{9}$/',         // Egypt

        // Africa
        'ZA' => '/^(\+27|0)?[1-9]\d{8}$/',         // South Africa
        'NG' => '/^(\+234|0)?[1-9]\d{9}$/',        // Nigeria
        'KE' => '/^(\+254|0)?[1-9]\d{8}$/',        // Kenya

        // South America
        'BR' => '/^(\+55)?[1-9]\d{9,10}$/',        // Brazil
        'AR' => '/^(\+54)?[1-9]\d{9,10}$/',        // Argentina
        'CO' => '/^(\+57)?[1-9]\d{9}$/',           // Colombia
        'CL' => '/^(\+56)?[1-9]\d{8}$/',           // Chile

        // Oceania
        'AU' => '/^(\+61|0)?[1-9]\d{8}$/',         // Australia
        'NZ' => '/^(\+64|0)?[2-9]\d{7,9}$/',       // New Zealand
    ];

    /**
     * Postal code patterns by country code
     */
    protected static array $postalPatterns = [
        // North America
        'US' => '/^\d{5}(-\d{4})?$/',              // 12345 or 12345-6789
        'CA' => '/^[A-Z]\d[A-Z]\s?\d[A-Z]\d$/i',   // A1A 1A1
        'MX' => '/^\d{5}$/',                       // 12345

        // Europe
        'DE' => '/^\d{5}$/',                       // 12345
        'FR' => '/^\d{5}$/',                       // 75001
        'GB' => '/^[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2}$/i', // SW1A 1AA
        'IT' => '/^\d{5}$/',                       // 00100
        'ES' => '/^\d{5}$/',                       // 28001
        'NL' => '/^\d{4}\s?[A-Z]{2}$/i',           // 1234 AB
        'BE' => '/^\d{4}$/',                       // 1000
        'CH' => '/^\d{4}$/',                       // 8000
        'AT' => '/^\d{4}$/',                       // 1010
        'PL' => '/^\d{2}-\d{3}$/',                 // 00-001
        'SE' => '/^\d{3}\s?\d{2}$/',               // 123 45
        'NO' => '/^\d{4}$/',                       // 0001
        'DK' => '/^\d{4}$/',                       // 1000
        'FI' => '/^\d{5}$/',                       // 00100
        'PT' => '/^\d{4}-\d{3}$/',                 // 1000-001
        'GR' => '/^\d{3}\s?\d{2}$/',               // 123 45
        'IE' => '/^[A-Z]\d{2}\s?[A-Z\d]{4}$/i',    // D02 XY45

        // Asia
        'IN' => '/^\d{6}$/',                       // 110001
        'CN' => '/^\d{6}$/',                       // 100000
        'JP' => '/^\d{3}-?\d{4}$/',                 // 100-0001 or 1000001
        'KR' => '/^\d{5}$/',                       // 12345
        'ID' => '/^\d{5}$/',                       // 12345
        'MY' => '/^\d{5}$/',                       // 50000
        'SG' => '/^\d{6}$/',                       // 123456
        'TH' => '/^\d{5}$/',                       // 10100
        'VN' => '/^\d{5,6}$/',                     // 10000
        'PH' => '/^\d{4}$/',                       // 1000
        'PK' => '/^\d{5}$/',                       // 44000
        'BD' => '/^\d{4}$/',                       // 1000

        // Middle East
        'AE' => '/^$/i',                           // UAE doesn't use postal codes
        'SA' => '/^\d{5}(-\d{4})?$/',              // 12345 or 12345-6789
        'IL' => '/^\d{7}$/',                       // 1234567
        'TR' => '/^\d{5}$/',                       // 34000

        // Africa
        'ZA' => '/^\d{4}$/',                       // 2000
        'NG' => '/^\d{6}$/',                       // 100001
        'KE' => '/^\d{5}$/',                       // 00100

        // South America
        'BR' => '/^\d{5}-?\d{3}$/',                // 01310-100
        'AR' => '/^[A-Z]\d{4}[A-Z]{3}$/i',         // C1425DKA
        'CO' => '/^\d{6}$/',                       // 110111
        'CL' => '/^\d{7}$/',                       // 8320000

        // Oceania
        'AU' => '/^\d{4}$/',                       // 2000
        'NZ' => '/^\d{4}$/',                       // 1010
    ];

    /**
     * Tax ID patterns by country code
     */
    protected static array $taxIdPatterns = [
        'US' => '/^\d{2}-\d{7}$/',                 // EIN: 12-3456789
        'DE' => '/^DE\d{9}$/i',                    // VAT: DE123456789
        'FR' => '/^FR[A-Z0-9]{2}\d{9}$/i',         // VAT: FR12345678901
        'GB' => '/^GB\d{9}(\d{3})?$/i',            // VAT: GB123456789(012)
        'IT' => '/^IT\d{11}$/i',                   // VAT: IT12345678901
        'ES' => '/^ES[A-Z0-9]\d{7}[A-Z0-9]$/i',    // VAT/NIF
        'NL' => '/^NL\d{9}B\d{2}$/i',              // VAT: NL123456789B01
        'BE' => '/^BE0?\d{9}$/i',                  // VAT: BE0123456789
        'IN' => '/^\d{2}[A-Z]{5}\d{4}[A-Z]\d[A-Z\d][A-Z\d]$/i', // GSTIN (15 alphanumeric)
        'AU' => '/^\d{11}$/',                      // ABN
        'BR' => '/^(\d{2}\.?\d{3}\.?\d{3}\/?\d{4}-?\d{2}|\d{14})$/', // CNPJ formatted or 14 digits
    ];

    /**
     * Get phone number pattern for country
     *
     * @param string $country ISO 3166-1 alpha-2 country code
     * @return string|null Regex pattern or null if not found
     */
    public static function getPhonePattern(string $country): ?string
    {
        return self::$phonePatterns[strtoupper($country)] ?? null;
    }

    /**
     * Get postal code pattern for country
     *
     * @param string $country ISO 3166-1 alpha-2 country code
     * @return string|null Regex pattern or null if not found
     */
    public static function getPostalPattern(string $country): ?string
    {
        return self::$postalPatterns[strtoupper($country)] ?? null;
    }

    /**
     * Get tax ID pattern for country
     *
     * @param string $country ISO 3166-1 alpha-2 country code
     * @return string|null Regex pattern or null if not found
     */
    public static function getTaxIdPattern(string $country): ?string
    {
        return self::$taxIdPatterns[strtoupper($country)] ?? null;
    }

    /**
     * Validate phone number for country
     *
     * @param string $phone Phone number
     * @param string $country ISO 3166-1 alpha-2 country code
     * @return bool True if valid
     */
    public static function validatePhone(string $phone, string $country): bool
    {
        $pattern = self::getPhonePattern($country);

        if ($pattern === null) {
            // If no pattern, perform basic validation
            return preg_match('/^\+?[0-9\s\-\(\)]{7,20}$/', $phone) === 1;
        }

        // Normalize phone number (remove spaces, dashes, parentheses)
        $normalized = preg_replace('/[\s\-\(\)]/', '', $phone);

        return preg_match($pattern, $normalized) === 1;
    }

    /**
     * Validate postal code for country
     *
     * @param string $code Postal code
     * @param string $country ISO 3166-1 alpha-2 country code
     * @return bool True if valid
     */
    public static function validatePostalCode(string $code, string $country): bool
    {
        $pattern = self::getPostalPattern($country);

        if ($pattern === null) {
            // If no pattern, accept any alphanumeric
            return preg_match('/^[A-Z0-9\s\-]{2,12}$/i', $code) === 1;
        }

        // Empty pattern means country doesn't use postal codes
        if ($pattern === '/^$/i') {
            return true;
        }

        return preg_match($pattern, trim($code)) === 1;
    }

    /**
     * Validate tax ID for country
     *
     * @param string $taxId Tax ID
     * @param string $country ISO 3166-1 alpha-2 country code
     * @return bool True if valid
     */
    public static function validateTaxId(string $taxId, string $country): bool
    {
        $pattern = self::getTaxIdPattern($country);

        if ($pattern === null) {
            return true; // No validation available
        }

        return preg_match($pattern, trim($taxId)) === 1;
    }

    /**
     * Get all supported countries for phone validation
     *
     * @return array Country codes
     */
    public static function getSupportedPhoneCountries(): array
    {
        return array_keys(self::$phonePatterns);
    }

    /**
     * Get all supported countries for postal validation
     *
     * @return array Country codes
     */
    public static function getSupportedPostalCountries(): array
    {
        return array_keys(self::$postalPatterns);
    }

    /**
     * Get all supported countries for tax ID validation
     *
     * @return array Country codes
     */
    public static function getSupportedTaxIdCountries(): array
    {
        return array_keys(self::$taxIdPatterns);
    }

    /**
     * Format phone number for display
     *
     * @param string $phone Phone number
     * @param string $country ISO 3166-1 alpha-2 country code
     * @return string Formatted phone number
     */
    public static function formatPhone(string $phone, string $country): string
    {
        // Normalize
        $phone = preg_replace('/[^\d+]/', '', $phone);

        // Country-specific formatting
        switch (strtoupper($country)) {
            case 'US':
            case 'CA':
                // Format as (XXX) XXX-XXXX
                if (preg_match('/^\+?1?(\d{3})(\d{3})(\d{4})$/', $phone, $matches)) {
                    return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
                }
                break;

            case 'DE':
                // Format as +49 XXX XXXXXXX
                if (preg_match('/^\+?49?(\d{2,4})(\d+)$/', $phone, $matches)) {
                    return "+49 {$matches[1]} {$matches[2]}";
                }
                break;

            case 'GB':
                // Format as +44 XXXX XXXXXX
                if (preg_match('/^\+?44?(\d{4})(\d{6})$/', $phone, $matches)) {
                    return "+44 {$matches[1]} {$matches[2]}";
                }
                break;
        }

        return $phone;
    }

    /**
     * Detect country from phone number
     *
     * @param string $phone Phone number (should start with +)
     * @return string|null ISO 3166-1 alpha-2 country code or null
     */
    public static function detectPhoneCountry(string $phone): ?string
    {
        // Normalize
        $phone = preg_replace('/[^\d+]/', '', $phone);

        if (!str_starts_with($phone, '+')) {
            return null;
        }

        // Country calling codes
        $callingCodes = [
            '1' => 'US',    // US/Canada (would need more logic to differentiate)
            '44' => 'GB',
            '49' => 'DE',
            '33' => 'FR',
            '39' => 'IT',
            '34' => 'ES',
            '91' => 'IN',
            '86' => 'CN',
            '81' => 'JP',
            '82' => 'KR',
            '61' => 'AU',
            '55' => 'BR',
            '971' => 'AE',
            '966' => 'SA',
            '972' => 'IL',
            '90' => 'TR',
            '62' => 'ID',
            '60' => 'MY',
            '65' => 'SG',
            '66' => 'TH',
            '84' => 'VN',
            '63' => 'PH',
            '92' => 'PK',
            '880' => 'BD',
            '27' => 'ZA',
            '234' => 'NG',
            '254' => 'KE',
            '52' => 'MX',
            '54' => 'AR',
            '57' => 'CO',
            '56' => 'CL',
            '64' => 'NZ',
        ];

        // Remove the +
        $number = substr($phone, 1);

        // Check 3-digit codes first, then 2-digit, then 1-digit
        foreach ([3, 2, 1] as $length) {
            $code = substr($number, 0, $length);
            if (isset($callingCodes[$code])) {
                return $callingCodes[$code];
            }
        }

        return null;
    }
}
