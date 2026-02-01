<?php

namespace Core\Localization\Pluralization\Rules;

use Core\Localization\Pluralization\PluralRuleInterface;

/**
 * AsianPluralRule
 *
 * Plural rule for languages without grammatical plural forms.
 *
 * Forms: other (only one form)
 * Many Asian languages don't distinguish between singular and plural
 * through grammar, using classifiers or context instead.
 *
 * Applies to:
 * - Chinese (zh, zh_CN, zh_TW)
 * - Japanese (ja)
 * - Korean (ko)
 * - Vietnamese (vi)
 * - Thai (th)
 * - Indonesian (id)
 * - Malay (ms)
 * - Turkish (tr)
 * - And others
 *
 * Examples:
 * - 1本, 2本, 100本 (Japanese - counter word used)
 * - 1个, 2个, 100个 (Chinese - classifier used)
 */
class AsianPluralRule implements PluralRuleInterface
{
    /**
     * {@inheritdoc}
     */
    public function choose(int|float $count): int
    {
        // Only one form - always return 0 (other)
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormCount(): int
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormNames(): array
    {
        return [self::OTHER];
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory(int|float $count): string
    {
        return self::OTHER;
    }
}
