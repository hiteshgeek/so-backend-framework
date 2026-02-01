<?php

namespace Core\Localization\Formatters;

use Core\Localization\LocaleManager;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * DateTimeFormatter
 *
 * Formats dates and times with locale-specific patterns and timezone support.
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
     * Date format patterns by locale and preset
     */
    protected array $dateFormats = [
        'en' => [
            'short' => 'n/j/y',
            'medium' => 'M j, Y',
            'long' => 'F j, Y',
            'full' => 'l, F j, Y',
        ],
        'fr' => [
            'short' => 'd/m/Y',
            'medium' => 'j M Y',
            'long' => 'j F Y',
            'full' => 'l j F Y',
        ],
        'de' => [
            'short' => 'd.m.y',
            'medium' => 'd. M Y',
            'long' => 'd. F Y',
            'full' => 'l, d. F Y',
        ],
        'es' => [
            'short' => 'd/m/y',
            'medium' => 'd M Y',
            'long' => 'd \d\e F \d\e Y',
            'full' => 'l, d \d\e F \d\e Y',
        ],
    ];

    /**
     * Time format patterns by locale and preset
     */
    protected array $timeFormats = [
        'en' => [
            'short' => 'g:i A',
            'medium' => 'g:i:s A',
            'long' => 'g:i:s A T',
        ],
        'fr' => [
            'short' => 'H:i',
            'medium' => 'H:i:s',
            'long' => 'H:i:s T',
        ],
        'de' => [
            'short' => 'H:i',
            'medium' => 'H:i:s',
            'long' => 'H:i:s T',
        ],
        'es' => [
            'short' => 'H:i',
            'medium' => 'H:i:s',
            'long' => 'H:i:s T',
        ],
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
     * Format date/time with locale and timezone
     *
     * @param DateTime|string $datetime DateTime object or string
     * @param string $format Format preset (short, medium, long, full) or custom format
     * @param string|null $locale Override locale
     * @param string|null $timezone Override timezone
     * @return string Formatted date/time
     */
    public function format(DateTime|string $datetime, string $format = 'medium', ?string $locale = null, ?string $timezone = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();
        $timezone = $timezone ?? $this->localeManager->getTimezone();

        // Convert string to DateTime
        $dateObj = $this->toDateTime($datetime, $timezone);

        // Get format pattern
        $pattern = $this->getDateTimePattern($format, $locale);

        return $dateObj->format($pattern);
    }

    /**
     * Format date only
     *
     * @param DateTime|string $date DateTime object or string
     * @param string $format Format preset or custom
     * @param string|null $locale Override locale
     * @return string Formatted date
     */
    public function formatDate(DateTime|string $date, string $format = 'medium', ?string $locale = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        // Convert string to DateTime
        $dateObj = $this->toDateTime($date);

        // Get format pattern
        $pattern = $this->getDatePattern($format, $locale);

        return $dateObj->format($pattern);
    }

    /**
     * Format time only
     *
     * @param DateTime|string $time DateTime object or string
     * @param string $format Format preset or custom
     * @param string|null $locale Override locale
     * @param string|null $timezone Override timezone
     * @return string Formatted time
     */
    public function formatTime(DateTime|string $time, string $format = 'medium', ?string $locale = null, ?string $timezone = null): string
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();
        $timezone = $timezone ?? $this->localeManager->getTimezone();

        // Convert string to DateTime
        $dateObj = $this->toDateTime($time, $timezone);

        // Get format pattern
        $pattern = $this->getTimePattern($format, $locale);

        return $dateObj->format($pattern);
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
     * Get date pattern for format preset
     *
     * @param string $format Format preset or custom pattern
     * @param string $locale Locale code
     * @return string PHP date format pattern
     */
    protected function getDatePattern(string $format, string $locale): string
    {
        // Check if it's a preset
        if (isset($this->dateFormats[$locale][$format])) {
            return $this->dateFormats[$locale][$format];
        }

        // Check default locale (en)
        if (isset($this->dateFormats['en'][$format])) {
            return $this->dateFormats['en'][$format];
        }

        // Assume it's a custom format
        return $format;
    }

    /**
     * Get time pattern for format preset
     *
     * @param string $format Format preset or custom pattern
     * @param string $locale Locale code
     * @return string PHP date format pattern
     */
    protected function getTimePattern(string $format, string $locale): string
    {
        // Check if it's a preset
        if (isset($this->timeFormats[$locale][$format])) {
            return $this->timeFormats[$locale][$format];
        }

        // Check default locale (en)
        if (isset($this->timeFormats['en'][$format])) {
            return $this->timeFormats['en'][$format];
        }

        // Assume it's a custom format
        return $format;
    }

    /**
     * Get combined date/time pattern
     *
     * @param string $format Format preset or custom pattern
     * @param string $locale Locale code
     * @return string PHP date format pattern
     */
    protected function getDateTimePattern(string $format, string $locale): string
    {
        // If custom format (contains PHP date format characters)
        if (str_contains($format, 'Y') || str_contains($format, 'H') || str_contains($format, 'i')) {
            return $format;
        }

        // Combine date and time patterns
        $datePattern = $this->getDatePattern($format, $locale);
        $timePattern = $this->getTimePattern($format, $locale);

        return $datePattern . ' ' . $timePattern;
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
     * Parse formatted date string to DateTime
     *
     * @param string $formatted Formatted date string
     * @param string $format Format pattern used
     * @param string|null $locale Locale code
     * @return DateTime|null DateTime object or null on failure
     */
    public function parse(string $formatted, string $format, ?string $locale = null): ?DateTime
    {
        $locale = $locale ?? $this->localeManager->getCurrentLocale();

        // Get format pattern
        $pattern = $this->getDatePattern($format, $locale);

        try {
            $dateObj = DateTime::createFromFormat($pattern, $formatted);
            return $dateObj !== false ? $dateObj : null;
        } catch (Exception $e) {
            return null;
        }
    }
}
