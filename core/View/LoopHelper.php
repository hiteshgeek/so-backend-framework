<?php

namespace Core\View;

/**
 * Provides loop iteration information
 *
 * Similar to Blade's $loop variable, this class provides useful
 * information about the current iteration state.
 *
 * Usage with loop() helper:
 *   <?php foreach (loop($items) as $item => $loop): ?>
 *       <?= $loop->iteration ?>. <?= $item ?>
 *       <?php if ($loop->first): ?> (first) <?php endif; ?>
 *       <?php if ($loop->last): ?> (last) <?php endif; ?>
 *   <?php endforeach; ?>
 *
 * Properties:
 *   $loop->index      - 0-based index
 *   $loop->iteration  - 1-based iteration number
 *   $loop->remaining  - Items remaining after current
 *   $loop->count      - Total number of items
 *   $loop->first      - Is first iteration
 *   $loop->last       - Is last iteration
 *   $loop->even       - Is even iteration (1-based)
 *   $loop->odd        - Is odd iteration (1-based)
 *   $loop->depth      - Nesting depth (1 for top level)
 *   $loop->parent     - Parent loop helper (for nested loops)
 */
class LoopHelper implements \ArrayAccess
{
    /**
     * 0-based index of current iteration
     */
    public int $index;

    /**
     * 1-based iteration number
     */
    public int $iteration;

    /**
     * Number of items remaining after current
     */
    public int $remaining;

    /**
     * Total number of items
     */
    public int $count;

    /**
     * Whether this is the first iteration
     */
    public bool $first;

    /**
     * Whether this is the last iteration
     */
    public bool $last;

    /**
     * Whether this is an even iteration (1-based)
     */
    public bool $even;

    /**
     * Whether this is an odd iteration (1-based)
     */
    public bool $odd;

    /**
     * Nesting depth (1 for top level, 2 for first nested loop, etc.)
     */
    public int $depth;

    /**
     * Parent loop helper for nested loops
     */
    public ?LoopHelper $parent;

    /**
     * Create a new LoopHelper instance
     *
     * @param int $index Current 0-based index
     * @param int $count Total items
     * @param int $depth Nesting depth
     * @param LoopHelper|null $parent Parent loop helper
     */
    public function __construct(int $index, int $count, int $depth = 1, ?LoopHelper $parent = null)
    {
        $this->index = $index;
        $this->iteration = $index + 1;
        $this->count = $count;
        $this->remaining = $count - $index - 1;
        $this->first = $index === 0;
        $this->last = $index === $count - 1;
        $this->even = ($index + 1) % 2 === 0;
        $this->odd = ($index + 1) % 2 === 1;
        $this->depth = $depth;
        $this->parent = $parent;
    }

    /**
     * Check if we've passed a given iteration
     *
     * @param int $count
     * @return bool
     */
    public function passedFirst(int $count = 1): bool
    {
        return $this->iteration > $count;
    }

    /**
     * Check if we haven't reached a given iteration
     *
     * @param int $count
     * @return bool
     */
    public function beforeLast(int $count = 1): bool
    {
        return $this->remaining >= $count;
    }

    /**
     * Check if iteration is within the last N items
     *
     * @param int $count
     * @return bool
     */
    public function isLast(int $count = 1): bool
    {
        return $this->remaining < $count;
    }

    /**
     * Check if iteration is within the first N items
     *
     * @param int $count
     * @return bool
     */
    public function isFirst(int $count = 1): bool
    {
        return $this->iteration <= $count;
    }

    /**
     * Get progress percentage (0-100)
     *
     * @return float
     */
    public function progress(): float
    {
        if ($this->count === 0) {
            return 100.0;
        }

        return ($this->iteration / $this->count) * 100;
    }

    // ArrayAccess implementation for $loop['index'] style access

    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }
        return null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        // Read-only
    }

    public function offsetUnset(mixed $offset): void
    {
        // Read-only
    }
}
