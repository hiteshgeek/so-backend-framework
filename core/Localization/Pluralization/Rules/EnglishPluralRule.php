<?php

namespace Core\Localization\Pluralization\Rules;

use Core\Localization\Pluralization\PluralRuleInterface;

/**
 * EnglishPluralRule
 *
 * Plural rule for English and similar languages (Germanic, Greek, etc.)
 *
 * Forms: one, other
 * - one: n = 1
 * - other: everything else
 *
 * Examples:
 * - 1 item (one)
 * - 0 items, 2 items, 5 items (other)
 *
 * Also applies to: de, el, es, it, nl, pt (European), etc.
 */
class EnglishPluralRule implements PluralRuleInterface
{
    /**
     * {@inheritdoc}
     */
    public function choose(int|float $count): int
    {
        $count = abs($count);

        // one: n = 1
        if ($count == 1) {
            return 0;
        }

        // other
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormCount(): int
    {
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormNames(): array
    {
        return [self::ONE, self::OTHER];
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory(int|float $count): string
    {
        return $this->getFormNames()[$this->choose($count)];
    }
}
