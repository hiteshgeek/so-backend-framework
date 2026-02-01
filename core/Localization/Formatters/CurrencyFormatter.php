<?php

namespace Core\Localization\Formatters;

use Core\Localization\LocaleManager;

/**
 * CurrencyFormatter
 *
 * Formats currency amounts with locale-specific symbols and separators.
 * Supports multiple currencies: USD, EUR, GBP, JPY, CNY, AED, SAR, INR, etc.
 *
 * Examples:
 * - en-US: $1,234.56
 * - fr-FR: 1 234,56 €
 * - de-DE: 1.234,56 €
 * - ja-JP: ¥1,234
 * - ar-AE: 1,234.56 د.إ
 */
class CurrencyFormatter
{
    /**
     * LocaleManager instance
     */
    protected LocaleManager $localeManager;

    /**
     * Currency symbols map
     */
    protected array $currencySymbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'JPY' => '¥',
        'CNY' => '¥',
        'AED' => 'د.إ',
        'SAR' => 'ر.س',
        'INR' => '₹',
        'CAD' => 'CA$',
        'AUD' => 'A$',
        'CHF' => 'CHF',
        'RUB' => '₽',
        'BRL' => 'R$',
        'MXN' => 'MX$',
        'KRW' => '₩',
    ];

    /**
     * Currencies with no decimal places
     */
    protected array $zeroDecimalCurrencies = [
        'JPY', 'KRW', 'VND', 'CLP', 'ISK', 'PYG', 'UGX', 'RWF', 'XAF', 'XOF',
    ];

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
     * Format currency amount
     *
     * @param float $amount Amount to format
     * @param string $currency Currency code (USD, EUR, etc.)
     * @param string|null $locale Override locale
     * @return string Formatted currency string
     * @throws \RuntimeException If formatting fails
     */
    public function format(float $amount, string $currency = 'USD', ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        // Map locale code to full locale (en -> en_US, fr -> fr_FR, etc.)
        $fullLocale = $this->getFullLocale($locale);

        $formatter = new \NumberFormatter($fullLocale, \NumberFormatter::CURRENCY);

        // Handle zero-decimal currencies (JPY, KRW, etc.)
        if (in_array($currency, $this->zeroDecimalCurrencies)) {
            $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);
        }

        $formatted = $formatter->formatCurrency($amount, $currency);

        // Throw exception if formatting failed
        if ($formatted === false) {
            throw new \RuntimeException(
                "Failed to format currency. Currency: {$currency}, Locale: {$fullLocale}"
            );
        }

        return $formatted;
    }

    /**
     * Format currency in accounting format (negative in parentheses)
     *
     * @param float $amount Amount to format
     * @param string $currency Currency code
     * @param string|null $locale Override locale
     * @return string Formatted currency string
     */
    public function formatAccounting(float $amount, string $currency = 'USD', ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();
        $formatted = $this->format(abs($amount), $currency, $locale);

        if ($amount < 0) {
            return "({$formatted})";
        }

        return $formatted;
    }

    /**
     * Get currency symbol
     *
     * @param string $currency Currency code
     * @param string|null $locale Override locale
     * @return string Currency symbol
     */
    public function getCurrencySymbol(string $currency, ?string $locale = null): string
    {
        return $this->currencySymbols[$currency] ?? $currency;
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

    /**
     * Parse formatted currency string to float
     *
     * @param string $formatted Formatted currency string
     * @param string $currency Currency code
     * @param string|null $locale Locale code
     * @return float Parsed amount
     */
    public function parse(string $formatted, string $currency, ?string $locale = null): float
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();
        $fullLocale = $this->getFullLocale($locale);

        // Use NumberFormatter to parse
        $formatter = new \NumberFormatter($fullLocale, \NumberFormatter::CURRENCY);
        $parsed = $formatter->parseCurrency($formatted, $currency);

        if ($parsed === false) {
            // Fallback to basic parsing if NumberFormatter fails
            $symbol = $this->getCurrencySymbol($currency);
            $cleaned = str_replace($symbol, '', $formatted);
            $cleaned = trim($cleaned);

            // Remove common separators and convert to float
            $cleaned = str_replace([',', ' ', '€', '$', '£', '¥', '₹'], '', $cleaned);

            // Handle accounting format (negative in parentheses)
            if (str_contains($cleaned, '(') && str_contains($cleaned, ')')) {
                $cleaned = str_replace(['(', ')'], '', $cleaned);
                $cleaned = '-' . $cleaned;
            }

            $parsed = (float) $cleaned;
        }

        return $parsed;
    }
}
