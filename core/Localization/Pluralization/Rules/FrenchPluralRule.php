<?php

namespace Core\Localization\Pluralization\Rules;

use Core\Localization\Pluralization\PluralRuleInterface;

/**
 * FrenchPluralRule
 *
 * Plural rule for French and Portuguese (Brazilian)
 *
 * Forms: one, other
 * - one: n = 0, 1 (differs from English: 0 is singular in French)
 * - other: everything else
 *
 * Examples:
 * - 0 livre, 1 livre (one)
 * - 2 livres, 5 livres (other)
 *
 * Also applies to: pt_BR (Brazilian Portuguese), hi (Hindi)
 */
class FrenchPluralRule implements PluralRuleInterface
{
    /**
     * {@inheritdoc}
     */
    public function choose(int|float $count): int
    {
        $count = abs($count);

        // one: n within 0..1 (inclusive)
        if ($count >= 0 && $count < 2) {
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
