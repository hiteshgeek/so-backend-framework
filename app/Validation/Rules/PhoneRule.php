<?php

namespace App\Validation\Rules;

use Core\Validation\Rule;
use Core\Localization\Validation\LocaleValidationRules;

/**
 * PhoneRule
 *
 * Validates phone numbers according to country-specific patterns.
 *
 * Usage:
 * ```php
 * $validator = new Validator($data, [
 *     'phone' => ['required', new PhoneRule('US')],
 *     'mobile' => ['required', new PhoneRule()], // Auto-detect country
 * ]);
 * ```
 */
class PhoneRule implements Rule
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

        return LocaleValidationRules::validatePhone($value, $this->country);
    }

    /**
     * Get the validation error message
     *
     * @return string
     */
    public function message(): string
    {
        $countryName = $this->getCountryName();

        return __('validation.phone', [
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
        // Try to get from locale manager
        if (function_exists('app') && app('locale')) {
            $locale = app('locale')->getCurrentLocale();
            $localeConfig = config("localization.locales.{$locale}", []);

            if (isset($localeConfig['country'])) {
                return $localeConfig['country'];
            }

            // Extract country from locale (e.g., en_US -> US)
            if (str_contains($locale, '_')) {
                $parts = explode('_', $locale);
                return strtoupper($parts[1]);
            }
        }

        return 'US'; // Default fallback
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
            'AE' => 'United Arab Emirates',
            'SA' => 'Saudi Arabia',
            // Add more as needed
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
