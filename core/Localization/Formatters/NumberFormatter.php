<?php

namespace Core\Localization\Formatters;

use Core\Localization\LocaleManager;

/**
 * NumberFormatter
 *
 * Formats numbers with locale-specific separators and decimal places.
 * Supports percentage formatting and file size formatting.
 *
 * Examples:
 * - en-US: 1,234.56
 * - fr-FR: 1 234,56
 * - de-DE: 1.234,56
 * - hi-IN: 1,23,456.00 (lakhs format)
 */
class NumberFormatter
{
    /**
     * LocaleManager instance
     */
    protected LocaleManager $localeManager;

    /**
     * Constructor
     *
     * @param LocaleManager $localeManager LocaleManager instance
     */
    public function __construct(LocaleManager $localeManager)
    {
        $this->localeManager = $localeManager;
    }

    /**
     * Format number with locale-specific separators
     *
     * @param float $number Number to format
     * @param int $decimals Decimal places (default: 2)
     * @param string|null $locale Override locale
     * @return string Formatted number
     */
    public function format(float $number, int $decimals = 2, ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        // Try using PHP Intl extension if available
        if (extension_loaded('intl')) {
            return $this->formatWithIntl($number, $decimals, $locale);
        }

        // Fallback to manual formatting
        return $this->formatManual($number, $decimals, $locale);
    }

    /**
     * Format percentage
     *
     * @param float $number Number to format (0.5 = 50%)
     * @param int $decimals Decimal places (default: 2)
     * @param string|null $locale Override locale
     * @return string Formatted percentage
     */
    public function formatPercent(float $number, int $decimals = 2, ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        // Try using PHP Intl extension if available
        if (extension_loaded('intl')) {
            $fullLocale = $this->getFullLocale($locale);
            $formatter = new \NumberFormatter($fullLocale, \NumberFormatter::PERCENT);
            $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $decimals);

            $formatted = $formatter->format($number);
            if ($formatted !== false) {
                return $formatted;
            }
        }

        // Fallback: multiply by 100 and add %
        $formatted = $this->format($number * 100, $decimals, $locale);
        return $formatted . '%';
    }

    /**
     * Format file size (bytes to human-readable)
     *
     * @param int $bytes Bytes
     * @param int $decimals Decimal places (default: 2)
     * @param string|null $locale Override locale
     * @return string Formatted file size
     */
    public function formatFileSize(int $bytes, int $decimals = 2, ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        $formatted = $this->format($bytes, $decimals, $locale);

        return $formatted . ' ' . $units[$i];
    }

    /**
     * Parse formatted number string to float
     *
     * @param string $formatted Formatted number string
     * @param string|null $locale Locale code
     * @return float Parsed number
     */
    public function parse(string $formatted, ?string $locale = null): float
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        // Get separators
        list($decimalSep, $thousandsSep) = $this->getSeparators($locale);

        // Remove thousands separator
        $cleaned = str_replace($thousandsSep, '', $formatted);

        // Replace decimal separator with dot
        $cleaned = str_replace($decimalSep, '.', $cleaned);

        // Remove any remaining non-numeric characters except dot and minus
        $cleaned = preg_replace('/[^0-9.\-]/', '', $cleaned);

        return (float) $cleaned;
    }

    /**
     * Format using PHP Intl extension
     *
     * @param float $number Number to format
     * @param int $decimals Decimal places
     * @param string $locale Locale code
     * @return string Formatted number
     */
    protected function formatWithIntl(float $number, int $decimals, string $locale): string
    {
        $fullLocale = $this->getFullLocale($locale);
        $formatter = new \NumberFormatter($fullLocale, \NumberFormatter::DECIMAL);
        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $decimals);

        $formatted = $formatter->format($number);

        // Fallback if formatting failed
        if ($formatted === false) {
            return $this->formatManual($number, $decimals, $locale);
        }

        return $formatted;
    }

    /**
     * Manual number formatting (fallback)
     *
     * @param float $number Number to format
     * @param int $decimals Decimal places
     * @param string $locale Locale code
     * @return string Formatted number
     */
    protected function formatManual(float $number, int $decimals, string $locale): string
    {
        // Get locale-specific separators
        list($decimalSep, $thousandsSep) = $this->getSeparators($locale);

        // Special handling for Indian numbering system (lakhs)
        if ($locale === 'hi' && abs($number) >= 1000) {
            return $this->formatIndianNumbering($number, $decimals, $decimalSep, $thousandsSep);
        }

        // Standard formatting
        return number_format($number, $decimals, $decimalSep, $thousandsSep);
    }

    /**
     * Format number in Indian numbering system (lakhs format)
     *
     * @param float $number Number to format
     * @param int $decimals Decimal places
     * @param string $decimalSep Decimal separator
     * @param string $thousandsSep Thousands separator
     * @return string Formatted number
     */
    protected function formatIndianNumbering(float $number, int $decimals, string $decimalSep, string $thousandsSep): string
    {
        $isNegative = $number < 0;
        $number = abs($number);

        // Split into integer and decimal parts
        $parts = explode('.', number_format($number, $decimals, '.', ''));
        $integer = $parts[0];
        $decimal = $parts[1] ?? '';

        // Indian format: First group of 3, then groups of 2
        // Example: 1,23,456 instead of 123,456
        if (strlen($integer) > 3) {
            $lastThree = substr($integer, -3);
            $remaining = substr($integer, 0, -3);

            // Group remaining digits by 2
            $formatted = '';
            while (strlen($remaining) > 0) {
                if (strlen($remaining) > 2) {
                    $formatted = $thousandsSep . substr($remaining, -2) . $formatted;
                    $remaining = substr($remaining, 0, -2);
                } else {
                    $formatted = $remaining . $formatted;
                    $remaining = '';
                }
            }

            $integer = $formatted . $thousandsSep . $lastThree;
        }

        $result = $integer;
        if ($decimals > 0 && $decimal !== '') {
            $result .= $decimalSep . $decimal;
        }

        return $isNegative ? '-' . $result : $result;
    }

    /**
     * Get decimal and thousands separators for locale
     *
     * @param string $locale Locale code
     * @return array [decimalSeparator, thousandsSeparator]
     */
    protected function getSeparators(string $locale): array
    {
        $separators = [
            'en' => ['.', ','],      // 1,234.56
            'fr' => [',', ' '],      // 1 234,56
            'de' => [',', '.'],      // 1.234,56
            'es' => [',', '.'],      // 1.234,56
            'it' => [',', '.'],      // 1.234,56
            'pt' => [',', '.'],      // 1.234,56
            'ru' => [',', ' '],      // 1 234,56
            'ar' => ['.', ','],      // 1,234.56
            'zh' => ['.', ','],      // 1,234.56
            'ja' => ['.', ','],      // 1,234.56
            'ko' => ['.', ','],      // 1,234.56
            'hi' => ['.', ','],      // 1,23,456.00 (lakhs)
        ];

        return $separators[$locale] ?? ['.', ','];
    }

    /**
     * Get full locale code from short code
     *
     * @param string $locale Short locale code (e.g., 'en')
     * @return string Full locale code (e.g., 'en_US')
     */
    protected function getFullLocale(string $locale): string
    {
        $localeMap = [
            'en' => 'en_US',
            'fr' => 'fr_FR',
            'de' => 'de_DE',
            'es' => 'es_ES',
            'it' => 'it_IT',
            'pt' => 'pt_BR',
            'ru' => 'ru_RU',
            'ar' => 'ar_AE',
            'zh' => 'zh_CN',
            'ja' => 'ja_JP',
            'ko' => 'ko_KR',
            'hi' => 'hi_IN',
        ];

        return $localeMap[$locale] ?? 'en_US';
    }
}
