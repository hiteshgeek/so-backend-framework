<?php

namespace Core\Model\Traits;

use Core\Database\QueryBuilder;

/**
 * HasStatusField Trait
 *
 * Provides flexible status field handling for models with non-standardized
 * status columns and values.
 *
 * Configuration Properties (define in your model):
 * - $statusField: The name of the status column (default: 'status')
 * - $activeStatusValues: Array of values that mean "active" (default: [1])
 * - $inactiveStatusValues: Array of values that mean "inactive" (default: [0])
 * - $autoFilterInactive: Automatically exclude inactive records (default: false)
 *
 * Query Scopes Provided:
 * - ::active() - Get only active records
 * - ::inactive() - Get only inactive records
 * - ::withStatus($values) - Get records with specific status value(s)
 * - ::withInactive() - Include inactive records (when auto-filter is on)
 * - ::onlyInactive() - Get only inactive records (when auto-filter is on)
 *
 * Instance Methods:
 * - ->isActive() - Check if record is active
 * - ->isInactive() - Check if record is inactive
 * - ->markAsActive() - Set status to first active value
 * - ->markAsInactive() - Set status to first inactive value
 * - ->getStatusValue() - Get current status value
 * - ->setStatus($value) - Set status to specific value
 *
 * Example Usage:
 *
 * ```php
 * class Product extends Model
 * {
 *     use HasStatusField;
 *
 *     protected static string $table = 'products';
 *     protected string $statusField = 'psid';
 *     protected array $activeStatusValues = [1];
 *     protected array $inactiveStatusValues = [2, 3];
 * }
 *
 * // Query scopes
 * $activeProducts = Product::active()->get();
 * $inactiveProducts = Product::inactive()->get();
 * $specificStatus = Product::withStatus([1, 2])->get();
 *
 * // Instance methods
 * if ($product->isActive()) {
 *     $product->markAsInactive();
 *     $product->save();
 * }
 * ```
 *
 * @package Core\Model\Traits
 */
trait HasStatusField
{
    /**
     * The name of the status field column
     * Override this in your model to match your table's status column
     *
     * @var string
     */
    protected $statusField = 'status';

    /**
     * Values that represent "active" status
     * Override this in your model
     *
     * @var array
     */
    protected $activeStatusValues = [1];

    /**
     * Values that represent "inactive" status
     * Override this in your model
     *
     * @var array
     */
    protected $inactiveStatusValues = [0];

    /**
     * Whether to automatically filter out inactive records on all queries
     * Set to true to enable global scope (like soft deletes)
     *
     * @var bool
     */
    protected $autoFilterInactive = false;

    /**
     * Track if we've applied the global scope
     * Used internally to prevent double-application
     *
     * @var bool
     */
    protected static bool $statusScopeApplied = false;

    /**
     * Boot the HasStatusField trait for the model
     * Called automatically by the Model's bootTraits() method
     */
    protected static function bootHasStatusField(): void
    {
        // Register a hook to apply global scope if enabled
        // This would require implementing a global scope system
        // For now, we'll rely on manual scope calls
    }

    // ==========================================
    // Query Scopes
    // ==========================================

    /**
     * Scope a query to only include active records
     *
     * @param QueryBuilder $query
     * @return QueryBuilder
     */
    public function scopeActive(QueryBuilder $query): QueryBuilder
    {
        $statusField = $this->getStatusFieldName();
        $activeValues = $this->getActiveStatusValues();

        if (count($activeValues) === 1) {
            return $query->where($statusField, '=', $activeValues[0]);
        }

        return $query->whereIn($statusField, $activeValues);
    }

    /**
     * Scope a query to only include inactive records
     *
     * @param QueryBuilder $query
     * @return QueryBuilder
     */
    public function scopeInactive(QueryBuilder $query): QueryBuilder
    {
        $statusField = $this->getStatusFieldName();
        $inactiveValues = $this->getInactiveStatusValues();

        if (count($inactiveValues) === 1) {
            return $query->where($statusField, '=', $inactiveValues[0]);
        }

        return $query->whereIn($statusField, $inactiveValues);
    }

    /**
     * Scope a query to include records with specific status value(s)
     *
     * @param QueryBuilder $query
     * @param int|array $statusValues Single value or array of values
     * @return QueryBuilder
     */
    public function scopeWithStatus(QueryBuilder $query, int|array $statusValues): QueryBuilder
    {
        $statusField = $this->getStatusFieldName();
        $statusValues = is_array($statusValues) ? $statusValues : [$statusValues];

        if (count($statusValues) === 1) {
            return $query->where($statusField, '=', $statusValues[0]);
        }

        return $query->whereIn($statusField, $statusValues);
    }

    /**
     * Scope a query to exclude specific status value(s)
     *
     * @param QueryBuilder $query
     * @param int|array $statusValues Single value or array of values
     * @return QueryBuilder
     */
    public function scopeWithoutStatus(QueryBuilder $query, int|array $statusValues): QueryBuilder
    {
        $statusField = $this->getStatusFieldName();
        $statusValues = is_array($statusValues) ? $statusValues : [$statusValues];

        if (count($statusValues) === 1) {
            return $query->where($statusField, '!=', $statusValues[0]);
        }

        return $query->whereNotIn($statusField, $statusValues);
    }

    /**
     * Scope to include inactive records (useful when auto-filter is enabled)
     * This is an alias for convenience when global scopes are implemented
     *
     * @param QueryBuilder $query
     * @return QueryBuilder
     */
    public function scopeWithInactive(QueryBuilder $query): QueryBuilder
    {
        // When global scopes are implemented, this would disable the auto-filter
        // For now, it's a no-op that returns the query as-is
        return $query;
    }

    /**
     * Scope to get only inactive records (alias for inactive())
     *
     * @param QueryBuilder $query
     * @return QueryBuilder
     */
    public function scopeOnlyInactive(QueryBuilder $query): QueryBuilder
    {
        return $this->scopeInactive($query);
    }

    // ==========================================
    // Instance Methods
    // ==========================================

    /**
     * Check if the current record is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        $statusValue = $this->getStatusValue();
        return in_array($statusValue, $this->getActiveStatusValues(), true);
    }

    /**
     * Check if the current record is inactive
     *
     * @return bool
     */
    public function isInactive(): bool
    {
        $statusValue = $this->getStatusValue();
        return in_array($statusValue, $this->getInactiveStatusValues(), true);
    }

    /**
     * Mark the record as active (sets to first active status value)
     * Note: You must call save() to persist the change
     *
     * @return self
     */
    public function markAsActive(): self
    {
        $activeValues = $this->getActiveStatusValues();

        if (empty($activeValues)) {
            throw new \RuntimeException(
                "No active status values defined for " . static::class
            );
        }

        $this->setStatus($activeValues[0]);
        return $this;
    }

    /**
     * Mark the record as inactive (sets to first inactive status value)
     * Note: You must call save() to persist the change
     *
     * @return self
     */
    public function markAsInactive(): self
    {
        $inactiveValues = $this->getInactiveStatusValues();

        if (empty($inactiveValues)) {
            throw new \RuntimeException(
                "No inactive status values defined for " . static::class
            );
        }

        $this->setStatus($inactiveValues[0]);
        return $this;
    }

    /**
     * Get the current status value
     *
     * @return mixed
     */
    public function getStatusValue(): mixed
    {
        $statusField = $this->getStatusFieldName();
        return $this->getAttribute($statusField);
    }

    /**
     * Set the status to a specific value
     * Note: You must call save() to persist the change
     *
     * @param mixed $value
     * @return self
     */
    public function setStatus(mixed $value): self
    {
        $statusField = $this->getStatusFieldName();
        $this->setAttribute($statusField, $value);
        return $this;
    }

    /**
     * Get a human-readable status name
     * Override this method in your model to provide custom labels
     *
     * @return string
     */
    public function getStatusName(): string
    {
        if ($this->isActive()) {
            return 'Active';
        }

        if ($this->isInactive()) {
            return 'Inactive';
        }

        return 'Unknown';
    }

    // ==========================================
    // Configuration Getters
    // ==========================================

    /**
     * Get the status field name for this model
     *
     * @return string
     */
    public function getStatusFieldName(): string
    {
        return $this->statusField ?? 'status';
    }

    /**
     * Get the active status values for this model
     *
     * @return array
     */
    public function getActiveStatusValues(): array
    {
        return $this->activeStatusValues ?? [1];
    }

    /**
     * Get the inactive status values for this model
     *
     * @return array
     */
    public function getInactiveStatusValues(): array
    {
        return $this->inactiveStatusValues ?? [0];
    }

    /**
     * Check if auto-filtering inactive records is enabled
     *
     * @return bool
     */
    public function shouldAutoFilterInactive(): bool
    {
        return $this->autoFilterInactive ?? false;
    }

    // ==========================================
    // Accessor for Status Field (Optional)
    // ==========================================

    /**
     * Get a status accessor if you want to add one
     * This is an example - uncomment and customize if needed
     *
     * public function getStatusAttribute($value)
     * {
     *     return [
     *         'value' => $value,
     *         'name' => $this->getStatusName(),
     *         'is_active' => $this->isActive(),
     *         'is_inactive' => $this->isInactive(),
     *     ];
     * }
     */
}
