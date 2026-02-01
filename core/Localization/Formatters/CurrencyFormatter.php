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
     */
    public function format(float $amount, string $currency = 'USD', ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        // Try using PHP Intl extension if available
        if (extension_loaded('intl')) {
            return $this->formatWithIntl($amount, $currency, $locale);
        }

        // Fallback to manual formatting
        return $this->formatManual($amount, $currency, $locale);
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
     * Format using PHP Intl extension
     *
     * @param float $amount Amount to format
     * @param string $currency Currency code
     * @param string $locale Locale code
     * @return string Formatted currency
     */
    protected function formatWithIntl(float $amount, string $currency, string $locale): string
    {
        // Map locale code to full locale (en -> en_US, fr -> fr_FR, etc.)
        $fullLocale = $this->getFullLocale($locale);

        $formatter = new \NumberFormatter($fullLocale, \NumberFormatter::CURRENCY);

        // Handle zero-decimal currencies
        if (in_array($currency, $this->zeroDecimalCurrencies)) {
            $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);
        }

        $formatted = $formatter->formatCurrency($amount, $currency);

        // Fallback if formatting failed
        if ($formatted === false) {
            return $this->formatManual($amount, $currency, $locale);
        }

        return $formatted;
    }

    /**
     * Manual currency formatting (fallback)
     *
     * @param float $amount Amount to format
     * @param string $currency Currency code
     * @param string $locale Locale code
     * @return string Formatted currency
     */
    protected function formatManual(float $amount, string $currency, string $locale): string
    {
        $symbol = $this->getCurrencySymbol($currency);

        // Determine decimal places
        $decimals = in_array($currency, $this->zeroDecimalCurrencies) ? 0 : 2;

        // Get locale-specific separators
        list($decimalSep, $thousandsSep) = $this->getSeparators($locale);

        // Format number
        $formatted = number_format($amount, $decimals, $decimalSep, $thousandsSep);

        // Position symbol based on locale and currency
        return $this->positionSymbol($formatted, $symbol, $locale, $currency);
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
            'ar' => ['.', ','],      // 1,234.56 (Arabic)
            'zh' => ['.', ','],      // 1,234.56 (Chinese)
            'ja' => ['.', ','],      // 1,234.56 (Japanese)
            'ko' => ['.', ','],      // 1,234.56 (Korean)
            'hi' => ['.', ','],      // 1,234.56 (Hindi)
        ];

        return $separators[$locale] ?? ['.', ','];
    }

    /**
     * Position currency symbol
     *
     * @param string $formattedNumber Formatted number
     * @param string $symbol Currency symbol
     * @param string $locale Locale code
     * @param string $currency Currency code
     * @return string Formatted currency with symbol
     */
    protected function positionSymbol(string $formattedNumber, string $symbol, string $locale, string $currency): string
    {
        // Symbol before (with space for some currencies)
        if (in_array($locale, ['en', 'zh', 'ja', 'ko'])) {
            return $symbol . $formattedNumber;
        }

        // Symbol after with space
        if (in_array($locale, ['fr', 'de', 'es', 'it', 'pt', 'ru'])) {
            return $formattedNumber . ' ' . $symbol;
        }

        // Symbol after (no space) for Arabic currencies
        if (in_array($locale, ['ar']) && in_array($currency, ['AED', 'SAR'])) {
            return $formattedNumber . ' ' . $symbol;
        }

        // Default: symbol before
        return $symbol . $formattedNumber;
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

        // Remove currency symbol
        $symbol = $this->getCurrencySymbol($currency);
        $cleaned = str_replace($symbol, '', $formatted);
        $cleaned = trim($cleaned);

        // Get separators
        list($decimalSep, $thousandsSep) = $this->getSeparators($locale);

        // Remove thousands separator
        $cleaned = str_replace($thousandsSep, '', $cleaned);

        // Replace decimal separator with dot
        $cleaned = str_replace($decimalSep, '.', $cleaned);

        // Handle accounting format (negative in parentheses)
        if (str_contains($cleaned, '(') && str_contains($cleaned, ')')) {
            $cleaned = str_replace(['(', ')'], '', $cleaned);
            $cleaned = '-' . $cleaned;
        }

        return (float) $cleaned;
    }
}
