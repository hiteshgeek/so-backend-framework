<?php

namespace Core\Localization\Pluralization\Rules;

use Core\Localization\Pluralization\PluralRuleInterface;

/**
 * PolishPluralRule
 *
 * Plural rule for Polish
 *
 * Forms: one, few, many, other
 * - one: n = 1
 * - few: n mod 10 in 2..4 and n mod 100 not in 12..14
 * - many: n != 1 and n mod 10 in 0..1 or n mod 10 in 5..9 or n mod 100 in 12..14
 * - other: for fractions
 *
 * Examples:
 * - 1 plik (one)
 * - 2 pliki, 3 pliki, 22 pliki (few)
 * - 0 plików, 5 plików, 11 plików, 25 plików (many)
 */
class PolishPluralRule implements PluralRuleInterface
{
    /**
     * {@inheritdoc}
     */
    public function choose(int|float $count): int
    {
        $count = abs($count);
        $n = (int) $count;

        // Handle non-integer (fractional) numbers
        if (floor($count) != $count) {
            return 3; // other
        }

        // one: n = 1
        if ($n === 1) {
            return 0;
        }

        $mod10 = $n % 10;
        $mod100 = $n % 100;

        // few: n mod 10 in 2..4 and n mod 100 not in 12..14
        if ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 12 || $mod100 > 14)) {
            return 1;
        }

        // many: everything else (except fractions)
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormCount(): int
    {
        return 4;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormNames(): array
    {
        return [self::ONE, self::FEW, self::MANY, self::OTHER];
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory(int|float $count): string
    {
        return $this->getFormNames()[$this->choose($count)];
    }
}
