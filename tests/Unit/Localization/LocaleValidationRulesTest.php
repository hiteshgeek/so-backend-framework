<?php

namespace Tests\Unit\Localization;

use PHPUnit\Framework\TestCase;
use Core\Localization\Validation\LocaleValidationRules;
use App\Validation\Rules\PhoneRule;
use App\Validation\Rules\PostalCodeRule;
use App\Validation\Rules\TaxIdRule;

/**
 * Locale Validation Rules Unit Tests
 *
 * Tests for country-specific validation patterns.
 * Covers: phone numbers, postal codes, tax IDs for 40+ countries.
 */
class LocaleValidationRulesTest extends TestCase
{
    // ===========================================
    // Phone Number Validation Tests
    // ===========================================

    /**
     * Test US phone number validation
     */
    public function testUsPhoneValidation(): void
    {
        // Valid US numbers
        $this->assertTrue(LocaleValidationRules::validatePhone('2025551234', 'US'));
        $this->assertTrue(LocaleValidationRules::validatePhone('+12025551234', 'US'));
        $this->assertTrue(LocaleValidationRules::validatePhone('12025551234', 'US'));

        // Invalid US numbers (starts with 0 or 1 in area code)
        $this->assertFalse(LocaleValidationRules::validatePhone('0025551234', 'US'));
        $this->assertFalse(LocaleValidationRules::validatePhone('1125551234', 'US'));
    }

    /**
     * Test UK phone number validation
     */
    public function testUkPhoneValidation(): void
    {
        // Valid UK numbers
        $this->assertTrue(LocaleValidationRules::validatePhone('+447911123456', 'GB'));
        $this->assertTrue(LocaleValidationRules::validatePhone('07911123456', 'GB'));
        $this->assertTrue(LocaleValidationRules::validatePhone('02079460123', 'GB'));
    }

    /**
     * Test German phone number validation
     */
    public function testGermanPhoneValidation(): void
    {
        // Valid German numbers
        $this->assertTrue(LocaleValidationRules::validatePhone('+4917612345678', 'DE'));
        $this->assertTrue(LocaleValidationRules::validatePhone('017612345678', 'DE'));
    }

    /**
     * Test French phone number validation
     */
    public function testFrenchPhoneValidation(): void
    {
        // Valid French numbers
        $this->assertTrue(LocaleValidationRules::validatePhone('+33612345678', 'FR'));
        $this->assertTrue(LocaleValidationRules::validatePhone('0612345678', 'FR'));
    }

    /**
     * Test Indian phone number validation
     */
    public function testIndianPhoneValidation(): void
    {
        // Valid Indian numbers (10 digits starting with 6-9)
        $this->assertTrue(LocaleValidationRules::validatePhone('9876543210', 'IN'));
        $this->assertTrue(LocaleValidationRules::validatePhone('+919876543210', 'IN'));

        // Invalid (starts with 0-5)
        $this->assertFalse(LocaleValidationRules::validatePhone('0123456789', 'IN'));
    }

    /**
     * Test UAE phone number validation
     */
    public function testUaePhoneValidation(): void
    {
        // Valid UAE numbers
        $this->assertTrue(LocaleValidationRules::validatePhone('+97150123456', 'AE'));
        $this->assertTrue(LocaleValidationRules::validatePhone('050123456', 'AE'));
    }

    /**
     * Test Saudi Arabia phone number validation
     */
    public function testSaudiPhoneValidation(): void
    {
        // Valid Saudi numbers
        $this->assertTrue(LocaleValidationRules::validatePhone('+966501234567', 'SA'));
        $this->assertTrue(LocaleValidationRules::validatePhone('0501234567', 'SA'));
    }

    /**
     * Test PhoneRule class
     */
    public function testPhoneRuleClass(): void
    {
        $rule = new PhoneRule('US');

        $this->assertTrue($rule->passes('phone', '2025551234'));
        $this->assertFalse($rule->passes('phone', 'not-a-phone'));

        // Test message
        $message = $rule->message();
        $this->assertIsString($message);
    }

    /**
     * Test PhoneRule with auto-detect country
     */
    public function testPhoneRuleAutoDetect(): void
    {
        $rule = new PhoneRule(); // Auto-detect from locale

        // Should have a default country
        $this->assertIsString($rule->getCountry());
    }

    // ===========================================
    // Postal Code Validation Tests
    // ===========================================

    /**
     * Test US ZIP code validation
     */
    public function testUsPostalCodeValidation(): void
    {
        // Valid US ZIP codes
        $this->assertTrue(LocaleValidationRules::validatePostalCode('12345', 'US'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('12345-6789', 'US'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validatePostalCode('1234', 'US'));
        $this->assertFalse(LocaleValidationRules::validatePostalCode('123456', 'US'));
        $this->assertFalse(LocaleValidationRules::validatePostalCode('ABCDE', 'US'));
    }

    /**
     * Test Canadian postal code validation
     */
    public function testCanadianPostalCodeValidation(): void
    {
        // Valid Canadian postal codes
        $this->assertTrue(LocaleValidationRules::validatePostalCode('A1A 1A1', 'CA'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('K1A0B1', 'CA'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('V6B 1A1', 'CA'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validatePostalCode('12345', 'CA'));
    }

    /**
     * Test UK postal code validation
     */
    public function testUkPostalCodeValidation(): void
    {
        // Valid UK postcodes
        $this->assertTrue(LocaleValidationRules::validatePostalCode('SW1A 1AA', 'GB'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('EC1A 1BB', 'GB'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('W1A 0AX', 'GB'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('M1 1AE', 'GB'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validatePostalCode('12345', 'GB'));
    }

    /**
     * Test German postal code validation
     */
    public function testGermanPostalCodeValidation(): void
    {
        // Valid German PLZ (5 digits)
        $this->assertTrue(LocaleValidationRules::validatePostalCode('10115', 'DE'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('80331', 'DE'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validatePostalCode('1234', 'DE'));
        $this->assertFalse(LocaleValidationRules::validatePostalCode('123456', 'DE'));
    }

    /**
     * Test French postal code validation
     */
    public function testFrenchPostalCodeValidation(): void
    {
        // Valid French codes (5 digits)
        $this->assertTrue(LocaleValidationRules::validatePostalCode('75001', 'FR'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('13001', 'FR'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validatePostalCode('7500', 'FR'));
    }

    /**
     * Test Indian postal code validation
     */
    public function testIndianPostalCodeValidation(): void
    {
        // Valid Indian PIN codes (6 digits)
        $this->assertTrue(LocaleValidationRules::validatePostalCode('110001', 'IN'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('400001', 'IN'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validatePostalCode('12345', 'IN'));
    }

    /**
     * Test Japanese postal code validation
     */
    public function testJapanesePostalCodeValidation(): void
    {
        // Valid Japanese codes (NNN-NNNN)
        $this->assertTrue(LocaleValidationRules::validatePostalCode('100-0001', 'JP'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('1000001', 'JP'));
    }

    /**
     * Test Australian postal code validation
     */
    public function testAustralianPostalCodeValidation(): void
    {
        // Valid Australian codes (4 digits)
        $this->assertTrue(LocaleValidationRules::validatePostalCode('2000', 'AU'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('3000', 'AU'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validatePostalCode('20000', 'AU'));
    }

    /**
     * Test PostalCodeRule class
     */
    public function testPostalCodeRuleClass(): void
    {
        $rule = new PostalCodeRule('US');

        $this->assertTrue($rule->passes('zip', '12345'));
        $this->assertFalse($rule->passes('zip', 'invalid'));

        // Test message
        $message = $rule->message();
        $this->assertIsString($message);
    }

    /**
     * Test PostalCodeRule for countries without postal codes
     */
    public function testPostalCodeForCountriesWithoutPostalCodes(): void
    {
        // UAE and Hong Kong don't use traditional postal codes
        $rule = new PostalCodeRule('AE');

        // Empty should be valid for these countries
        $this->assertTrue($rule->passes('postal_code', ''));
    }

    // ===========================================
    // Tax ID Validation Tests
    // ===========================================

    /**
     * Test US EIN validation
     */
    public function testUsEinValidation(): void
    {
        // Valid US EIN (XX-XXXXXXX)
        $this->assertTrue(LocaleValidationRules::validateTaxId('12-3456789', 'US'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validateTaxId('123456789', 'US'));
        $this->assertFalse(LocaleValidationRules::validateTaxId('AB-CDEFGHI', 'US'));
    }

    /**
     * Test German VAT ID validation
     */
    public function testGermanVatIdValidation(): void
    {
        // Valid German USt-IdNr (DE + 9 digits)
        $this->assertTrue(LocaleValidationRules::validateTaxId('DE123456789', 'DE'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validateTaxId('DE12345678', 'DE')); // Too short
        $this->assertFalse(LocaleValidationRules::validateTaxId('123456789', 'DE')); // No prefix
    }

    /**
     * Test UK VAT number validation
     */
    public function testUkVatValidation(): void
    {
        // Valid UK VAT (GB + 9 or 12 digits)
        $this->assertTrue(LocaleValidationRules::validateTaxId('GB123456789', 'GB'));
        $this->assertTrue(LocaleValidationRules::validateTaxId('GB123456789012', 'GB'));
    }

    /**
     * Test French VAT ID validation
     */
    public function testFrenchVatValidation(): void
    {
        // Valid French TVA (FR + 2 chars + 9 digits)
        $this->assertTrue(LocaleValidationRules::validateTaxId('FR12345678901', 'FR'));
    }

    /**
     * Test Italian VAT ID validation
     */
    public function testItalianVatValidation(): void
    {
        // Valid Italian P.IVA (IT + 11 digits)
        $this->assertTrue(LocaleValidationRules::validateTaxId('IT12345678901', 'IT'));
    }

    /**
     * Test Spanish VAT ID validation
     */
    public function testSpanishVatValidation(): void
    {
        // Valid Spanish NIF/CIF
        $this->assertTrue(LocaleValidationRules::validateTaxId('ESA12345678', 'ES'));
        $this->assertTrue(LocaleValidationRules::validateTaxId('ESB12345678', 'ES'));
    }

    /**
     * Test Indian GSTIN validation
     */
    public function testIndianGstinValidation(): void
    {
        // Valid GSTIN (15 alphanumeric)
        $this->assertTrue(LocaleValidationRules::validateTaxId('22AAAAA0000A1Z5', 'IN'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validateTaxId('12345', 'IN'));
    }

    /**
     * Test Australian ABN validation
     */
    public function testAustralianAbnValidation(): void
    {
        // Valid ABN (11 digits)
        $this->assertTrue(LocaleValidationRules::validateTaxId('12345678901', 'AU'));

        // Invalid
        $this->assertFalse(LocaleValidationRules::validateTaxId('1234567890', 'AU'));
    }

    /**
     * Test Brazilian CNPJ validation
     */
    public function testBrazilianCnpjValidation(): void
    {
        // Valid CNPJ (14 digits, often formatted as XX.XXX.XXX/XXXX-XX)
        $this->assertTrue(LocaleValidationRules::validateTaxId('12345678000195', 'BR'));
        $this->assertTrue(LocaleValidationRules::validateTaxId('12.345.678/0001-95', 'BR'));
    }

    /**
     * Test TaxIdRule class
     */
    public function testTaxIdRuleClass(): void
    {
        $rule = new TaxIdRule('DE');

        $this->assertTrue($rule->passes('vat', 'DE123456789'));
        $this->assertFalse($rule->passes('vat', 'invalid'));

        // Test message returns string (may be translation key or actual message)
        $message = $rule->message();
        $this->assertIsString($message);
        $this->assertNotEmpty($message);
    }

    /**
     * Test TaxIdRule returns correct country
     */
    public function testTaxIdRuleCountry(): void
    {
        $usRule = new TaxIdRule('US');
        $this->assertEquals('US', $usRule->getCountry());

        $deRule = new TaxIdRule('DE');
        $this->assertEquals('DE', $deRule->getCountry());

        $inRule = new TaxIdRule('IN');
        $this->assertEquals('IN', $inRule->getCountry());
    }

    // ===========================================
    // Edge Cases and Error Handling
    // ===========================================

    /**
     * Test validation with null values
     */
    public function testNullValues(): void
    {
        $phoneRule = new PhoneRule('US');
        $this->assertFalse($phoneRule->passes('phone', null));

        $postalRule = new PostalCodeRule('US');
        $this->assertFalse($postalRule->passes('postal', null));

        $taxRule = new TaxIdRule('US');
        $this->assertFalse($taxRule->passes('tax', null));
    }

    /**
     * Test validation with empty strings
     */
    public function testEmptyStrings(): void
    {
        $phoneRule = new PhoneRule('US');
        $this->assertFalse($phoneRule->passes('phone', ''));

        $taxRule = new TaxIdRule('US');
        $this->assertFalse($taxRule->passes('tax', ''));
    }

    /**
     * Test validation with whitespace
     */
    public function testWhitespace(): void
    {
        // Phone with spaces (should be handled - spaces are normalized)
        $this->assertTrue(LocaleValidationRules::validatePhone('+1 202 555 1234', 'US'));

        // Postal with hyphen (correct US ZIP+4 format)
        $this->assertTrue(LocaleValidationRules::validatePostalCode('12345-6789', 'US'));

        // UK postcode with space
        $this->assertTrue(LocaleValidationRules::validatePostalCode('SW1A 1AA', 'GB'));
    }

    /**
     * Test unknown country fallback
     */
    public function testUnknownCountry(): void
    {
        // Should return true (no validation) or false (strict)
        $phoneResult = LocaleValidationRules::validatePhone('1234567890', 'XX');
        $this->assertIsBool($phoneResult);

        $postalResult = LocaleValidationRules::validatePostalCode('12345', 'XX');
        $this->assertIsBool($postalResult);
    }

    /**
     * Test country code case insensitivity
     */
    public function testCountryCodeCaseInsensitivity(): void
    {
        $this->assertTrue(LocaleValidationRules::validatePostalCode('12345', 'us'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('12345', 'US'));
        $this->assertTrue(LocaleValidationRules::validatePostalCode('12345', 'Us'));
    }

    /**
     * Test getPhonePattern returns pattern or null
     */
    public function testGetPhonePattern(): void
    {
        $usPattern = LocaleValidationRules::getPhonePattern('US');
        $this->assertNotNull($usPattern);
        $this->assertIsString($usPattern);

        // Unknown country
        $xxPattern = LocaleValidationRules::getPhonePattern('XX');
        $this->assertNull($xxPattern);
    }

    /**
     * Test getPostalPattern returns pattern or null
     */
    public function testGetPostalPattern(): void
    {
        $usPattern = LocaleValidationRules::getPostalPattern('US');
        $this->assertNotNull($usPattern);
        $this->assertIsString($usPattern);

        // Unknown country
        $xxPattern = LocaleValidationRules::getPostalPattern('XX');
        $this->assertNull($xxPattern);
    }

    /**
     * Test getTaxIdPattern returns pattern or null
     */
    public function testGetTaxIdPattern(): void
    {
        $usPattern = LocaleValidationRules::getTaxIdPattern('US');
        $this->assertNotNull($usPattern);
        $this->assertIsString($usPattern);
    }

    /**
     * Test all supported countries have patterns
     */
    public function testSupportedCountries(): void
    {
        $countries = ['US', 'GB', 'DE', 'FR', 'ES', 'IT', 'NL', 'BE', 'IN', 'AU', 'BR', 'CA', 'JP', 'CN'];

        foreach ($countries as $country) {
            $phonePattern = LocaleValidationRules::getPhonePattern($country);
            $this->assertNotNull(
                $phonePattern,
                "Phone pattern should exist for {$country}"
            );
        }
    }
}
