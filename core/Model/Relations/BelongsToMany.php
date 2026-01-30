<?php

namespace Core\Model\Relations;

use Core\Model\Model;

/**
 * BelongsToMany Relationship
 *
 * Represents a many-to-many relationship via an intermediate pivot table.
 * Both models reference each other through foreign keys on the pivot table.
 *
 * Usage:
 *   // In User model:
 *   public function roles(): BelongsToMany
 *   {
 *       return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
 *   }
 *
 *   // Access:
 *   $user->roles; // Returns array of Role models
 *
 * Table structure example:
 *   users:     id, name, email
 *   roles:     id, name
 *   role_user: id, user_id, role_id  (pivot table)
 */
class BelongsToMany extends Relation
{
    /**
     * The name of the pivot/intermediate table.
     */
    protected string $pivotTable;

    /**
     * The foreign key on the pivot table for the parent model.
     * E.g. 'user_id' on the role_user pivot when querying from User.
     */
    protected string $foreignPivotKey;

    /**
     * The foreign key on the pivot table for the related model.
     * E.g. 'role_id' on the role_user pivot when querying from User to Role.
     */
    protected string $relatedPivotKey;

    /**
     * Create a new BelongsToMany relation instance.
     *
     * @param Model  $parent          The parent model instance
     * @param string $related         The related model class name
     * @param string $pivotTable      The pivot/intermediate table name
     * @param string $foreignPivotKey Foreign key for the parent on the pivot table
     * @param string $relatedPivotKey Foreign key for the related model on the pivot table
     * @param string $localKey        The local key on the parent model (usually 'id')
     */
    public function __construct(
        Model $parent,
        string $related,
        string $pivotTable,
        string $foreignPivotKey,
        string $relatedPivotKey,
        string $localKey = 'id'
    ) {
        $this->pivotTable = $pivotTable;
        $this->foreignPivotKey = $foreignPivotKey;
        $this->relatedPivotKey = $relatedPivotKey;

        // The foreignKey in the parent Relation class is not used directly
        // for BelongsToMany, but we set it to foreignPivotKey for consistency.
        parent::__construct($parent, $related, $foreignPivotKey, $localKey);
    }

    /**
     * Execute the relationship query.
     *
     * Performs a JOIN between the related model's table and the pivot table,
     * then filters by the parent model's key value.
     *
     * SQL equivalent:
     *   SELECT {related_table}.*
     *   FROM {related_table}
     *   INNER JOIN {pivot_table}
     *     ON {related_table}.id = {pivot_table}.{related_pivot_key}
     *   WHERE {pivot_table}.{foreign_pivot_key} = {parent.local_key}
     *
     * @return array Array of related Model instances (empty array if none found)
     */
    public function get(): array
    {
        $parentKeyValue = $this->getParentKeyValue();

        if ($parentKeyValue === null) {
            return [];
        }

        /** @var Model $relatedInstance */
        $relatedInstance = new $this->related();
        $relatedTable = $relatedInstance->getTable();
        $relatedPrimaryKey = $relatedInstance->getPrimaryKey();

        $results = $this->newQuery()
            ->select($relatedTable . '.*')
            ->join(
                $this->pivotTable,
                $relatedTable . '.' . $relatedPrimaryKey,
                '=',
                $this->pivotTable . '.' . $this->relatedPivotKey
            )
            ->where($this->pivotTable . '.' . $this->foreignPivotKey, '=', $parentKeyValue)
            ->get();

        return $this->hydrateModels($results);
    }

    /**
     * Get the pivot table name.
     *
     * @return string
     */
    public function getPivotTable(): string
    {
        return $this->pivotTable;
    }

    /**
     * Get the foreign pivot key name (parent side).
     *
     * @return string
     */
    public function getForeignPivotKey(): string
    {
        return $this->foreignPivotKey;
    }

    /**
     * Get the related pivot key name (related side).
     *
     * @return string
     */
    public function getRelatedPivotKey(): string
    {
        return $this->relatedPivotKey;
    }
}
