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
     * @throws \RuntimeException If formatting fails
     */
    public function format(float $number, int $decimals = 2, ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();
        $fullLocale = $this->getFullLocale($locale);

        $formatter = new \NumberFormatter($fullLocale, \NumberFormatter::DECIMAL);
        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $decimals);

        $formatted = $formatter->format($number);

        if ($formatted === false) {
            throw new \RuntimeException(
                "Failed to format number. Number: {$number}, Locale: {$fullLocale}"
            );
        }

        return $formatted;
    }

    /**
     * Format percentage
     *
     * @param float $number Number to format (0.5 = 50%)
     * @param int $decimals Decimal places (default: 2)
     * @param string|null $locale Override locale
     * @return string Formatted percentage
     * @throws \RuntimeException If formatting fails
     */
    public function formatPercent(float $number, int $decimals = 2, ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();
        $fullLocale = $this->getFullLocale($locale);

        $formatter = new \NumberFormatter($fullLocale, \NumberFormatter::PERCENT);
        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $decimals);

        $formatted = $formatter->format($number);

        if ($formatted === false) {
            throw new \RuntimeException(
                "Failed to format percentage. Number: {$number}, Locale: {$fullLocale}"
            );
        }

        return $formatted;
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
        $fullLocale = $this->getFullLocale($locale);

        // Use NumberFormatter to parse
        $formatter = new \NumberFormatter($fullLocale, \NumberFormatter::DECIMAL);
        $parsed = $formatter->parse($formatted);

        if ($parsed === false) {
            // Fallback to basic parsing if NumberFormatter fails
            $cleaned = preg_replace('/[^0-9.\-,]/', '', $formatted);
            $cleaned = str_replace(',', '', $cleaned);
            $parsed = (float) $cleaned;
        }

        return $parsed;
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
