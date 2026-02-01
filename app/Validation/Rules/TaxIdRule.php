<?php

namespace App\Validation\Rules;

use Core\Validation\Rule;
use Core\Localization\Validation\LocaleValidationRules;

/**
 * TaxIdRule
 *
 * Validates tax identification numbers according to country-specific patterns.
 * Supports VAT numbers, EIN, GSTIN, ABN, CNPJ, and other formats.
 *
 * Usage:
 * ```php
 * $validator = new Validator($data, [
 *     'vat_number' => ['required', new TaxIdRule('DE')],
 *     'ein' => ['required', new TaxIdRule('US')],
 *     'gstin' => ['required', new TaxIdRule('IN')],
 * ]);
 * ```
 */
class TaxIdRule implements Rule
{
    /**
     * Country code for validation
     */
    protected string $country;

    /**
     * Constructor
     *
     * @param string|null $country ISO 3166-1 alpha-2 country code (null = auto-detect)
     */
    public function __construct(?string $country = null)
    {
        $this->country = $country ?? $this->detectCountry();
    }

    /**
     * Determine if the validation rule passes
     *
     * @param string $attribute Attribute name
     * @param mixed $value Attribute value
     * @return bool
     */
    public function passes(string $attribute, mixed $value): bool
    {
        if (!is_string($value) || empty($value)) {
            return false;
        }

        return LocaleValidationRules::validateTaxId($value, $this->country);
    }

    /**
     * Get the validation error message
     *
     * @return string
     */
    public function message(): string
    {
        $countryName = $this->getCountryName();
        $taxIdName = $this->getTaxIdName();

        return __('validation.tax_id', [
            'country' => $countryName,
            'type' => $taxIdName,
        ]);
    }

    /**
     * Detect country from locale configuration
     *
     * @return string Country code
     */
    protected function detectCountry(): string
    {
        if (function_exists('app') && app('locale')) {
            $locale = app('locale')->getCurrentLocale();
            $localeConfig = config("localization.locales.{$locale}", []);

            if (isset($localeConfig['country'])) {
                return $localeConfig['country'];
            }

            if (str_contains($locale, '_')) {
                $parts = explode('_', $locale);
                return strtoupper($parts[1]);
            }
        }

        return 'US';
    }

    /**
     * Get human-readable country name
     *
     * @return string Country name
     */
    protected function getCountryName(): string
    {
        $countries = [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'DE' => 'Germany',
            'FR' => 'France',
            'IT' => 'Italy',
            'ES' => 'Spain',
            'NL' => 'Netherlands',
            'BE' => 'Belgium',
            'IN' => 'India',
            'AU' => 'Australia',
            'BR' => 'Brazil',
        ];

        return $countries[$this->country] ?? $this->country;
    }

    /**
     * Get tax ID name for country
     *
     * @return string Tax ID name
     */
    protected function getTaxIdName(): string
    {
        $taxIdNames = [
            'US' => 'EIN',
            'GB' => 'VAT number',
            'DE' => 'USt-IdNr',
            'FR' => 'TVA',
            'IT' => 'P.IVA',
            'ES' => 'NIF/CIF',
            'NL' => 'BTW',
            'BE' => 'TVA/BTW',
            'IN' => 'GSTIN',
            'AU' => 'ABN',
            'BR' => 'CNPJ',
        ];

        return $taxIdNames[$this->country] ?? 'Tax ID';
    }

    /**
     * Get the country code
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }
}
