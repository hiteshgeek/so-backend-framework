<?php

namespace Core\Localization\Pluralization;

/**
 * PluralRuleInterface
 *
 * Interface for language-specific plural rules based on CLDR (Common Locale Data Repository).
 *
 * Different languages have different plural categories:
 * - English: 2 forms (one, other)
 * - French: 2 forms (one/other, but 0 is singular)
 * - Russian/Polish: 4 forms (one, few, many, other)
 * - Arabic: 6 forms (zero, one, two, few, many, other)
 * - Asian languages: 1 form (other only)
 *
 * @see https://cldr.unicode.org/index/cldr-spec/plural-rules
 */
interface PluralRuleInterface
{
    /**
     * CLDR plural category constants
     */
    public const ZERO = 'zero';
    public const ONE = 'one';
    public const TWO = 'two';
    public const FEW = 'few';
    public const MANY = 'many';
    public const OTHER = 'other';

    /**
     * Get the plural form index for a given count
     *
     * Returns the index (0-based) of the plural form to use.
     *
     * @param int|float $count The number to determine plural form for
     * @return int Index of the plural form (0-based)
     */
    public function choose(int|float $count): int;

    /**
     * Get the number of plural forms for this language
     *
     * @return int Number of plural forms
     */
    public function getFormCount(): int;

    /**
     * Get the CLDR plural category names for this language
     *
     * Returns array like ['one', 'other'] or ['one', 'few', 'many', 'other']
     *
     * @return array Array of plural category names
     */
    public function getFormNames(): array;

    /**
     * Get the plural category name for a count
     *
     * Returns the CLDR category name (one, few, many, other, etc.)
     *
     * @param int|float $count The number
     * @return string Category name
     */
    public function getCategory(int|float $count): string;
}
