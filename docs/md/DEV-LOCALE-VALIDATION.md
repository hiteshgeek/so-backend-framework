# Locale Validation Rules

## Overview

The framework provides country-specific validation rules for phone numbers, postal codes, tax IDs, and other locale-specific formats for 40+ countries.

## Phone Number Validation

### Country-Specific Phone Validation

```php
use Core\Validation\Validator;

// Validate phone number for specific country
$validator = new Validator($_POST, [
    'phone' => 'required|phone:US',  // US phone format
    'mobile' => 'required|phone:UK', // UK phone format
]);

// Multiple countries
$validator = new Validator($_POST, [
    'phone' => 'required|phone:US,CA,MX', // North American formats
]);
```

### Supported Phone Formats

```php
// United States: +1 (555) 123-4567
'phone' => 'phone:US'

// United Kingdom: +44 20 1234 5678
'phone' => 'phone:UK'

// India: +91 98765 43210
'phone' => 'phone:IN'

// Saudi Arabia: +966 50 123 4567
'phone' => 'phone:SA'

// UAE: +971 50 123 4567
'phone' => 'phone:AE'

// Germany: +49 30 12345678
'phone' => 'phone:DE'

// France: +33 1 23 45 67 89
'phone' => 'phone:FR'
```

## Postal Code Validation

### By Country

```php
// US ZIP codes: 12345 or 12345-6789
$validator = new Validator($_POST, [
    'zip' => 'required|postal_code:US',
]);

// UK postcodes: SW1A 1AA
$validator = new Validator($_POST, [
    'postcode' => 'required|postal_code:UK',
]);

// Canadian postal codes: K1A 0B1
$validator = new Validator($_POST, [
    'postal_code' => 'required|postal_code:CA',
]);
```

### Supported Postal Code Formats

| Country | Format | Example |
|---------|--------|---------|
| US | 12345 or 12345-6789 | 90210-1234 |
| UK | AA99 9AA | SW1A 1AA |
| CA | A9A 9A9 | K1A 0B1 |
| DE | 99999 | 10115 |
| FR | 99999 | 75001 |
| IN | 999999 | 110001 |
| AU | 9999 | 2000 |
| BR | 99999-999 | 01310-100 |
| MX | 99999 | 01000 |
| JP | 999-9999 | 100-0001 |

## Tax ID Validation

### Social Security Numbers (SSN)

```php
// US SSN: 123-45-6789
$validator = new Validator($_POST, [
    'ssn' => 'required|tax_id:US',
]);
```

### National ID Numbers

```php
// Saudi Arabia National ID
$validator = new Validator($_POST, [
    'national_id' => 'required|tax_id:SA',
]);

// UK National Insurance Number: AB123456C
$validator = new Validator($_POST, [
    'ni_number' => 'required|tax_id:UK',
]);

// German Tax ID (Steuer-IdNr)
$validator = new Validator($_POST, [
    'tax_id' => 'required|tax_id:DE',
]);
```

### Business Tax IDs

```php
// US EIN (Employer Identification Number): 12-3456789
$validator = new Validator($_POST, [
    'ein' => 'required|business_tax_id:US',
]);

// UK VAT Number: GB123456789
$validator = new Validator($_POST, [
    'vat' => 'required|business_tax_id:UK',
]);
```

## IBAN Validation

```php
// International Bank Account Number
$validator = new Validator($_POST, [
    'iban' => 'required|iban',
]);

// Country-specific IBAN
$validator = new Validator($_POST, [
    'iban' => 'required|iban:DE',  // German IBAN only
]);

// Valid examples:
// DE89370400440532013000 (Germany)
// GB29NWBK60161331926819 (UK)
// FR1420041010050500013M02606 (France)
```

## Credit Card Validation

```php
// Any credit card type
$validator = new Validator($_POST, [
    'card_number' => 'required|credit_card',
]);

// Specific card types
$validator = new Validator($_POST, [
    'card_number' => 'required|credit_card:visa,mastercard',
]);

// Supported types:
// - visa
// - mastercard
// - amex
// - discover
// - diners
// - jcb
```

## Date Format Validation

### Locale-Specific Date Formats

```php
// US date format: MM/DD/YYYY
$validator = new Validator($_POST, [
    'birth_date' => 'required|date_format:US',
]);

// European date format: DD/MM/YYYY
$validator = new Validator($_POST, [
    'birth_date' => 'required|date_format:EU',
]);

// ISO date format: YYYY-MM-DD
$validator = new Validator($_POST, [
    'birth_date' => 'required|date_format:ISO',
]);
```

## Currency Validation

```php
// Validate currency code
$validator = new Validator($_POST, [
    'currency' => 'required|currency_code',
]);
// Valid: USD, EUR, GBP, SAR, AED, etc.

// Validate currency amount
$validator = new Validator($_POST, [
    'amount' => 'required|currency_amount:USD',
]);
// Valid: 1234.56, 1,234.56
```

## Complete Country-Specific Example

```php
use Core\Validation\Validator;

// Validate US customer data
$validator = new Validator($_POST, [
    'first_name' => 'required|string|max:50',
    'last_name' => 'required|string|max:50',
    'phone' => 'required|phone:US',
    'zip_code' => 'required|postal_code:US',
    'ssn' => 'nullable|tax_id:US',
    'state' => 'required|in:' . implode(',', US_STATES),
]);

// Validate UK customer data
$validator = new Validator($_POST, [
    'first_name' => 'required|string|max:50',
    'surname' => 'required|string|max:50',
    'mobile' => 'required|phone:UK',
    'postcode' => 'required|postal_code:UK',
    'ni_number' => 'nullable|tax_id:UK',
    'county' => 'nullable|string',
]);

// Validate Saudi Arabia customer data
$validator = new Validator($_POST, [
    'first_name' => 'required|string|max:50',
    'last_name' => 'required|string|max:50',
    'mobile' => 'required|phone:SA',
    'national_id' => 'required|tax_id:SA',
    'city' => 'required|in:Riyadh,Jeddah,Mecca,Medina,Dammam',
]);
```

## Custom Validation Messages

```php
$validator = new Validator($_POST, [
    'phone' => 'required|phone:US',
], [
    'phone.phone' => 'Please enter a valid US phone number (e.g., +1 555-123-4567)',
]);
```

## Creating Custom Locale Validators

```php
use Core\Validation\Validator;

// Add custom rule
Validator::extend('custom_phone', function($value, $parameters) {
    // Your validation logic
    return preg_match('/your-pattern/', $value);
});

// Usage
$validator = new Validator($_POST, [
    'phone' => 'required|custom_phone',
]);
```

## Supported Countries

The framework includes validation rules for 40+ countries:

**Americas**: US, CA, MX, BR, AR, CL, CO
**Europe**: UK, DE, FR, ES, IT, NL, BE, SE, NO, DK, FI, PL, AT, CH, IE
**Middle East**: SA, AE, QA, KW, BH, OM, JO, EG
**Asia Pacific**: IN, CN, JP, KR, SG, MY, TH, ID, PH, VN, AU, NZ

## Related Documentation

- [Validation System](/docs/validation-system)
- [Forms & Validation](/docs/dev-forms-validation)
- [Internationalization](/docs/localization)
- [Translation Commands](/docs/dev-translation-commands)
