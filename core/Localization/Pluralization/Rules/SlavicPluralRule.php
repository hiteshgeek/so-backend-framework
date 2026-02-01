<?php

namespace Core\Localization\Pluralization\Rules;

use Core\Localization\Pluralization\PluralRuleInterface;

/**
 * SlavicPluralRule
 *
 * Plural rule for Russian, Ukrainian, Belarusian, Serbian, Croatian
 *
 * Forms: one, few, many, other
 * - one: n mod 10 = 1 and n mod 100 != 11
 * - few: n mod 10 in 2..4 and n mod 100 not in 12..14
 * - many: n mod 10 = 0 or n mod 10 in 5..9 or n mod 100 in 11..14
 * - other: used for fractions
 *
 * Examples (Russian):
 * - 1 товар, 21 товар, 31 товар (one)
 * - 2 товара, 3 товара, 22 товара (few)
 * - 0 товаров, 5 товаров, 11 товаров, 20 товаров (many)
 *
 * Also applies to: uk, be, sr, hr, bs
 */
class SlavicPluralRule implements PluralRuleInterface
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
            return 3; // other - for fractions
        }

        $mod10 = $n % 10;
        $mod100 = $n % 100;

        // one: n mod 10 = 1 and n mod 100 != 11
        if ($mod10 === 1 && $mod100 !== 11) {
            return 0;
        }

        // few: n mod 10 in 2..4 and n mod 100 not in 12..14
        if ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 12 || $mod100 > 14)) {
            return 1;
        }

        // many: n mod 10 = 0 or n mod 10 in 5..9 or n mod 100 in 11..14
        if ($mod10 === 0 || ($mod10 >= 5 && $mod10 <= 9) || ($mod100 >= 11 && $mod100 <= 14)) {
            return 2;
        }

        // other (fallback)
        return 3;
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
