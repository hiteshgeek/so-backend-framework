<?php

namespace Core\Localization\Pluralization\Rules;

use Core\Localization\Pluralization\PluralRuleInterface;

/**
 * ArabicPluralRule
 *
 * Plural rule for Arabic
 *
 * Forms: zero, one, two, few, many, other
 * - zero: n = 0
 * - one: n = 1
 * - two: n = 2
 * - few: n mod 100 in 3..10
 * - many: n mod 100 in 11..99
 * - other: everything else
 *
 * Arabic has the most complex plural system with 6 forms.
 *
 * Examples:
 * - 0 كتب (zero)
 * - 1 كتاب (one)
 * - 2 كتابان (two - dual form)
 * - 3 كتب, 10 كتب (few)
 * - 11 كتاباً, 99 كتاباً (many)
 * - 100 كتاب, 1000 كتاب (other)
 */
class ArabicPluralRule implements PluralRuleInterface
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
            return 5; // other
        }

        // zero: n = 0
        if ($n === 0) {
            return 0;
        }

        // one: n = 1
        if ($n === 1) {
            return 1;
        }

        // two: n = 2
        if ($n === 2) {
            return 2;
        }

        $mod100 = $n % 100;

        // few: n mod 100 in 3..10
        if ($mod100 >= 3 && $mod100 <= 10) {
            return 3;
        }

        // many: n mod 100 in 11..99
        if ($mod100 >= 11 && $mod100 <= 99) {
            return 4;
        }

        // other
        return 5;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormCount(): int
    {
        return 6;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormNames(): array
    {
        return [self::ZERO, self::ONE, self::TWO, self::FEW, self::MANY, self::OTHER];
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory(int|float $count): string
    {
        return $this->getFormNames()[$this->choose($count)];
    }
}
