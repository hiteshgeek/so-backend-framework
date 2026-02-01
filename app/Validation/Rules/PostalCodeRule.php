<?php

namespace App\Validation\Rules;

use Core\Validation\Rule;
use Core\Localization\Validation\LocaleValidationRules;

/**
 * PostalCodeRule
 *
 * Validates postal/ZIP codes according to country-specific patterns.
 *
 * Usage:
 * ```php
 * $validator = new Validator($data, [
 *     'zip' => ['required', new PostalCodeRule('US')],
 *     'postal_code' => ['required', new PostalCodeRule('CA')],
 * ]);
 * ```
 */
class PostalCodeRule implements Rule
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
        if (!is_string($value)) {
            return false;
        }

        // Some countries don't use postal codes
        if (empty($value) && in_array($this->country, ['AE', 'HK'])) {
            return true;
        }

        return LocaleValidationRules::validatePostalCode($value, $this->country);
    }

    /**
     * Get the validation error message
     *
     * @return string
     */
    public function message(): string
    {
        $countryName = $this->getCountryName();

        return __('validation.postal_code', [
            'country' => $countryName,
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
            'IN' => 'India',
            'CN' => 'China',
            'JP' => 'Japan',
            'AU' => 'Australia',
            'BR' => 'Brazil',
        ];

        return $countries[$this->country] ?? $this->country;
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
