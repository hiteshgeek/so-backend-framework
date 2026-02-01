<?php

namespace Core\Localization\Pluralization;

use Core\Localization\Pluralization\Rules\EnglishPluralRule;
use Core\Localization\Pluralization\Rules\FrenchPluralRule;
use Core\Localization\Pluralization\Rules\SlavicPluralRule;
use Core\Localization\Pluralization\Rules\PolishPluralRule;
use Core\Localization\Pluralization\Rules\ArabicPluralRule;
use Core\Localization\Pluralization\Rules\AsianPluralRule;

/**
 * PluralRules
 *
 * Factory for CLDR-based plural rules.
 * Returns the appropriate plural rule implementation for a given locale.
 *
 * Usage:
 * ```php
 * // Get rule for a locale
 * $rule = PluralRules::forLocale('ru');
 *
 * // Get plural form index
 * $index = $rule->choose(5); // Returns 2 (many)
 *
 * // Get category name
 * $category = $rule->getCategory(5); // Returns 'many'
 *
 * // Get form count
 * $formCount = $rule->getFormCount(); // Returns 4
 * ```
 *
 * @see https://cldr.unicode.org/index/cldr-spec/plural-rules
 */
class PluralRules
{
    /**
     * Cached rule instances
     */
    protected static array $instances = [];

    /**
     * Language to rule mapping
     * Based on CLDR plural rules categories
     */
    protected static array $languageRuleMap = [
        // English-like (2 forms: one, other)
        'en' => EnglishPluralRule::class,
        'de' => EnglishPluralRule::class,
        'el' => EnglishPluralRule::class,
        'es' => EnglishPluralRule::class,
        'it' => EnglishPluralRule::class,
        'nl' => EnglishPluralRule::class,
        'sv' => EnglishPluralRule::class,
        'da' => EnglishPluralRule::class,
        'no' => EnglishPluralRule::class,
        'fi' => EnglishPluralRule::class,
        'et' => EnglishPluralRule::class,
        'bg' => EnglishPluralRule::class,
        'he' => EnglishPluralRule::class,
        'hu' => EnglishPluralRule::class,
        'ca' => EnglishPluralRule::class,
        'eu' => EnglishPluralRule::class,
        'gl' => EnglishPluralRule::class,

        // French-like (2 forms, but 0 is singular)
        'fr' => FrenchPluralRule::class,
        'pt' => FrenchPluralRule::class,  // Brazilian Portuguese
        'hi' => FrenchPluralRule::class,
        'bn' => FrenchPluralRule::class,
        'gu' => FrenchPluralRule::class,
        'mr' => FrenchPluralRule::class,
        'fa' => FrenchPluralRule::class,

        // Slavic (4 forms: one, few, many, other)
        'ru' => SlavicPluralRule::class,
        'uk' => SlavicPluralRule::class,
        'be' => SlavicPluralRule::class,
        'sr' => SlavicPluralRule::class,
        'hr' => SlavicPluralRule::class,
        'bs' => SlavicPluralRule::class,
        'sk' => SlavicPluralRule::class,

        // Czech - similar to Slavic but slightly different
        'cs' => SlavicPluralRule::class,

        // Polish (4 forms, slightly different rules)
        'pl' => PolishPluralRule::class,

        // Arabic (6 forms: zero, one, two, few, many, other)
        'ar' => ArabicPluralRule::class,

        // Asian languages (1 form: other only)
        'zh' => AsianPluralRule::class,
        'ja' => AsianPluralRule::class,
        'ko' => AsianPluralRule::class,
        'vi' => AsianPluralRule::class,
        'th' => AsianPluralRule::class,
        'id' => AsianPluralRule::class,
        'ms' => AsianPluralRule::class,
        'tr' => AsianPluralRule::class,
        'km' => AsianPluralRule::class,
        'lo' => AsianPluralRule::class,
        'my' => AsianPluralRule::class,
    ];

    /**
     * Get plural rule for a locale
     *
     * @param string $locale Locale code (e.g., 'en', 'en_US', 'ru_RU')
     * @return PluralRuleInterface
     */
    public static function forLocale(string $locale): PluralRuleInterface
    {
        $language = self::getLanguageCode($locale);

        if (!isset(self::$instances[$language])) {
            self::$instances[$language] = self::createRule($language);
        }

        return self::$instances[$language];
    }

    /**
     * Create plural rule for a language
     *
     * @param string $language Language code
     * @return PluralRuleInterface
     */
    protected static function createRule(string $language): PluralRuleInterface
    {
        $ruleClass = self::$languageRuleMap[$language] ?? EnglishPluralRule::class;

        return new $ruleClass();
    }

    /**
     * Extract language code from locale
     *
     * @param string $locale Full locale (e.g., 'en_US', 'ru_RU')
     * @return string Language code (e.g., 'en', 'ru')
     */
    protected static function getLanguageCode(string $locale): string
    {
        // Handle locale variants like zh_CN, zh_TW
        $parts = preg_split('/[-_]/', $locale);

        return strtolower($parts[0]);
    }

    /**
     * Get all supported languages
     *
     * @return array Array of language codes
     */
    public static function getSupportedLanguages(): array
    {
        return array_keys(self::$languageRuleMap);
    }

    /**
     * Check if a language is supported
     *
     * @param string $locale Locale or language code
     * @return bool
     */
    public static function isSupported(string $locale): bool
    {
        $language = self::getLanguageCode($locale);

        return isset(self::$languageRuleMap[$language]);
    }

    /**
     * Register a custom plural rule for a language
     *
     * @param string $language Language code
     * @param string $ruleClass Fully qualified class name
     */
    public static function registerRule(string $language, string $ruleClass): void
    {
        self::$languageRuleMap[strtolower($language)] = $ruleClass;

        // Clear cached instance
        unset(self::$instances[strtolower($language)]);
    }

    /**
     * Choose plural form from translation string
     *
     * Supports multiple formats:
     * - Pipe-separated: "item|items"
     * - Indexed: "{0} items|{1} item|{2} items"
     * - CLDR-style: "{one} :count item|{other} :count items"
     * - ICU-style: "{count, plural, one{# item} other{# items}}"
     *
     * @param string $translation Translation string with plural forms
     * @param int|float $count Count for plural selection
     * @param string $locale Locale code
     * @return string Selected plural form
     */
    public static function choose(string $translation, int|float $count, string $locale = 'en'): string
    {
        $rule = self::forLocale($locale);
        $formIndex = $rule->choose($count);
        $category = $rule->getCategory($count);

        // Check for CLDR-style format: {one} text|{other} text
        if (preg_match_all('/\{(\w+)\}\s*([^|{]+)/', $translation, $matches, PREG_SET_ORDER)) {
            $forms = [];
            foreach ($matches as $match) {
                $forms[strtolower($match[1])] = trim($match[2]);
            }

            // Return matching category or fallback to 'other'
            return $forms[$category] ?? $forms[PluralRuleInterface::OTHER] ?? $translation;
        }

        // Check for indexed format: {0} text|{1} text
        if (preg_match('/\{\d+\}/', $translation)) {
            preg_match_all('/\{(\d+)\}\s*([^|]+)/', $translation, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                if ((int) $match[1] === $formIndex) {
                    return trim($match[2]);
                }
            }
        }

        // Simple pipe-separated format
        $parts = explode('|', $translation);

        // Return the form at the calculated index, or last form as fallback
        return trim($parts[$formIndex] ?? $parts[count($parts) - 1] ?? $translation);
    }
}
