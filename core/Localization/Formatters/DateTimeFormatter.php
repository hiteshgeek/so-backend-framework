<?php

namespace Core\Localization\Formatters;

use Core\Localization\LocaleManager;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Exception;

/**
 * DateTimeFormatter
 *
 * Formats dates and times with locale-specific patterns using IntlDateFormatter.
 * Supports relative time formatting ("2 days ago") and multiple format presets.
 *
 * Format Presets:
 * - short: 1/15/26 or 3:30 PM
 * - medium: Jan 15, 2026 or 3:30:25 PM
 * - long: January 15, 2026 or 3:30:25 PM EST
 * - full: Wednesday, January 15, 2026
 */
class DateTimeFormatter
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
     * Format date/time with locale and timezone using IntlDateFormatter
     *
     * @param DateTime|string $datetime DateTime object or string
     * @param string $format Format preset (short, medium, long, full)
     * @param string|null $locale Override locale
     * @param string|null $timezone Override timezone
     * @return string Formatted date/time
     * @throws \RuntimeException If formatting fails
     */
    public function format(DateTime|string $datetime, string $format = 'medium', ?string $locale = null, ?string $timezone = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();
        $timezone = $timezone ?? $this->localeManager->getTimezone();

        // Convert string to DateTime
        $dateObj = $this->toDateTime($datetime, $timezone);

        // Map to IntlDateFormatter constants
        $formatMap = [
            'short' => [IntlDateFormatter::SHORT, IntlDateFormatter::SHORT],
            'medium' => [IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM],
            'long' => [IntlDateFormatter::LONG, IntlDateFormatter::LONG],
            'full' => [IntlDateFormatter::FULL, IntlDateFormatter::FULL],
        ];

        [$dateFormat, $timeFormat] = $formatMap[$format] ?? $formatMap['medium'];

        // Get full locale
        $fullLocale = $this->getFullLocale($locale);

        // Create IntlDateFormatter
        $formatter = new IntlDateFormatter(
            $fullLocale,
            $dateFormat,
            $timeFormat,
            $dateObj->getTimezone()
        );

        $result = $formatter->format($dateObj);

        if ($result === false) {
            throw new \RuntimeException(
                "Failed to format datetime. Locale: {$fullLocale}, Format: {$format}"
            );
        }

        return $result;
    }

    /**
     * Format date only using IntlDateFormatter
     *
     * @param DateTime|string $date DateTime object or string
     * @param string $format Format preset (short, medium, long, full)
     * @param string|null $locale Override locale
     * @return string Formatted date
     * @throws \RuntimeException If formatting fails
     */
    public function formatDate(DateTime|string $date, string $format = 'medium', ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        // Convert string to DateTime
        $dateObj = $this->toDateTime($date);

        // Map to IntlDateFormatter constants
        $formatMap = [
            'short' => IntlDateFormatter::SHORT,
            'medium' => IntlDateFormatter::MEDIUM,
            'long' => IntlDateFormatter::LONG,
            'full' => IntlDateFormatter::FULL,
        ];

        $dateFormat = $formatMap[$format] ?? IntlDateFormatter::MEDIUM;
        $fullLocale = $this->getFullLocale($locale);

        // Create IntlDateFormatter (date only, no time)
        $formatter = new IntlDateFormatter(
            $fullLocale,
            $dateFormat,
            IntlDateFormatter::NONE,
            $dateObj->getTimezone()
        );

        $result = $formatter->format($dateObj);

        if ($result === false) {
            throw new \RuntimeException(
                "Failed to format date. Locale: {$fullLocale}, Format: {$format}"
            );
        }

        return $result;
    }

    /**
     * Format time only using IntlDateFormatter
     *
     * @param DateTime|string $time DateTime object or string
     * @param string $format Format preset (short, medium, long, full)
     * @param string|null $locale Override locale
     * @param string|null $timezone Override timezone
     * @return string Formatted time
     * @throws \RuntimeException If formatting fails
     */
    public function formatTime(DateTime|string $time, string $format = 'medium', ?string $locale = null, ?string $timezone = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();
        $timezone = $timezone ?? $this->localeManager->getTimezone();

        // Convert string to DateTime
        $dateObj = $this->toDateTime($time, $timezone);

        // Map to IntlDateFormatter constants
        $formatMap = [
            'short' => IntlDateFormatter::SHORT,
            'medium' => IntlDateFormatter::MEDIUM,
            'long' => IntlDateFormatter::LONG,
            'full' => IntlDateFormatter::FULL,
        ];

        $timeFormat = $formatMap[$format] ?? IntlDateFormatter::MEDIUM;
        $fullLocale = $this->getFullLocale($locale);

        // Create IntlDateFormatter (time only, no date)
        $formatter = new IntlDateFormatter(
            $fullLocale,
            IntlDateFormatter::NONE,
            $timeFormat,
            $dateObj->getTimezone()
        );

        $result = $formatter->format($dateObj);

        if ($result === false) {
            throw new \RuntimeException(
                "Failed to format time. Locale: {$fullLocale}, Format: {$format}"
            );
        }

        return $result;
    }

    /**
     * Format relative time (e.g., "2 days ago", "in 3 hours")
     *
     * @param DateTime|string $datetime DateTime object or string
     * @param string|null $locale Override locale
     * @return string Relative time string
     */
    public function formatRelative(DateTime|string $datetime, ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        // Convert string to DateTime
        $dateObj = $this->toDateTime($datetime);
        $now = new DateTime();

        $diff = $now->getTimestamp() - $dateObj->getTimestamp();
        $absDiff = abs($diff);

        // Future or past
        $isPast = $diff > 0;

        // Calculate units
        $seconds = $absDiff;
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $weeks = floor($days / 7);
        $months = floor($days / 30);
        $years = floor($days / 365);

        // Determine unit and value
        if ($years > 0) {
            return $this->formatRelativeString($years, 'year', $isPast, $locale);
        } elseif ($months > 0) {
            return $this->formatRelativeString($months, 'month', $isPast, $locale);
        } elseif ($weeks > 0) {
            return $this->formatRelativeString($weeks, 'week', $isPast, $locale);
        } elseif ($days > 0) {
            return $this->formatRelativeString($days, 'day', $isPast, $locale);
        } elseif ($hours > 0) {
            return $this->formatRelativeString($hours, 'hour', $isPast, $locale);
        } elseif ($minutes > 0) {
            return $this->formatRelativeString($minutes, 'minute', $isPast, $locale);
        } else {
            return $this->getRelativeString('just_now', $locale);
        }
    }

    /**
     * Format relative string
     *
     * @param int $value Number value
     * @param string $unit Unit (year, month, day, etc.)
     * @param bool $isPast Is in the past
     * @param string $locale Locale code
     * @return string Formatted relative string
     */
    protected function formatRelativeString(int $value, string $unit, bool $isPast, string $locale): string
    {
        $unitText = $value === 1 ? $unit : $unit . 's';

        // English
        if ($locale === 'en') {
            return $isPast ? "$value $unitText ago" : "in $value $unitText";
        }

        // French
        if ($locale === 'fr') {
            $units = [
                'year' => 'an', 'years' => 'ans',
                'month' => 'mois', 'months' => 'mois',
                'week' => 'semaine', 'weeks' => 'semaines',
                'day' => 'jour', 'days' => 'jours',
                'hour' => 'heure', 'hours' => 'heures',
                'minute' => 'minute', 'minutes' => 'minutes',
            ];
            $unitText = $units[$unitText] ?? $unitText;
            return $isPast ? "il y a $value $unitText" : "dans $value $unitText";
        }

        // German
        if ($locale === 'de') {
            $units = [
                'year' => 'Jahr', 'years' => 'Jahre',
                'month' => 'Monat', 'months' => 'Monate',
                'week' => 'Woche', 'weeks' => 'Wochen',
                'day' => 'Tag', 'days' => 'Tage',
                'hour' => 'Stunde', 'hours' => 'Stunden',
                'minute' => 'Minute', 'minutes' => 'Minuten',
            ];
            $unitText = $units[$unitText] ?? $unitText;
            return $isPast ? "vor $value $unitText" : "in $value $unitText";
        }

        // Default to English
        return $isPast ? "$value $unitText ago" : "in $value $unitText";
    }

    /**
     * Get relative string for special cases
     *
     * @param string $key Key (just_now, etc.)
     * @param string $locale Locale code
     * @return string Relative string
     */
    protected function getRelativeString(string $key, string $locale): string
    {
        $strings = [
            'en' => ['just_now' => 'just now'],
            'fr' => ['just_now' => 'à l\'instant'],
            'de' => ['just_now' => 'gerade eben'],
            'es' => ['just_now' => 'ahora mismo'],
        ];

        return $strings[$locale][$key] ?? $strings['en'][$key];
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
     * Convert string or DateTime to DateTime object
     *
     * @param DateTime|string $datetime DateTime or string
     * @param string|null $timezone Timezone
     * @return DateTime
     * @throws Exception
     */
    protected function toDateTime(DateTime|string $datetime, ?string $timezone = null): DateTime
    {
        if ($datetime instanceof DateTime) {
            $dateObj = clone $datetime;
        } else {
            try {
                $dateObj = new DateTime($datetime);
            } catch (Exception $e) {
                // Fallback to current time
                $dateObj = new DateTime();
            }
        }

        // Apply timezone if specified
        if ($timezone) {
            try {
                $dateObj->setTimezone(new DateTimeZone($timezone));
            } catch (Exception $e) {
                // Invalid timezone, ignore
            }
        }

        return $dateObj;
    }

    /**
     * Parse formatted date string to DateTime using IntlDateFormatter
     *
     * @param string $formatted Formatted date string
     * @param string $format Format preset (short, medium, long, full)
     * @param string|null $locale Locale code
     * @return DateTime|null DateTime object or null on failure
     */
    public function parse(string $formatted, string $format = 'medium', ?string $locale = null): ?DateTime
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();
        $fullLocale = $this->getFullLocale($locale);

        // Map to IntlDateFormatter constants
        $formatMap = [
            'short' => IntlDateFormatter::SHORT,
            'medium' => IntlDateFormatter::MEDIUM,
            'long' => IntlDateFormatter::LONG,
            'full' => IntlDateFormatter::FULL,
        ];

        $dateFormat = $formatMap[$format] ?? IntlDateFormatter::MEDIUM;

        try {
            $formatter = new IntlDateFormatter(
                $fullLocale,
                $dateFormat,
                IntlDateFormatter::NONE
            );

            $timestamp = $formatter->parse($formatted);

            if ($timestamp === false) {
                return null;
            }

            $dateObj = new DateTime();
            $dateObj->setTimestamp($timestamp);

            return $dateObj;
        } catch (Exception $e) {
            return null;
        }
    }
}
