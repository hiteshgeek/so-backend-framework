<?php

namespace Core\Database;

/**
 * Raw SQL Expression
 *
 * Allows using raw SQL expressions in queries without escaping.
 * Use with caution - values are not parameterized.
 *
 * Usage:
 *   new RawExpression('NOW()')
 *   new RawExpression('price + 10')
 */
class RawExpression
{
    /**
     * The raw SQL expression
     */
    protected string $value;

    /**
     * Create a new raw expression
     *
     * @param string $value The raw SQL expression
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Get the raw expression value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
