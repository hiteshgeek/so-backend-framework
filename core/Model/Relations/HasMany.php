<?php

namespace Core\Model\Relations;

use Core\Model\Model;

/**
 * HasMany Relationship
 *
 * Represents a one-to-many relationship where the parent model
 * has zero or more instances of the related model. The foreign key
 * resides on the related model's table.
 *
 * Usage:
 *   // In User model:
 *   public function posts(): HasMany
 *   {
 *       return $this->hasMany(Post::class, 'user_id', 'id');
 *   }
 *
 *   // Access:
 *   $user->posts; // Returns array of Post models (may be empty)
 */
class HasMany extends Relation
{
    /**
     * Execute the relationship query.
     *
     * Fetches all related records where the foreign key matches
     * the parent model's local key value.
     *
     * SQL equivalent:
     *   SELECT * FROM {related_table}
     *   WHERE {foreign_key} = {parent.local_key}
     *
     * @return array Array of related Model instances (empty array if none found)
     */
    public function get(): array
    {
        $parentKeyValue = $this->getParentKeyValue();

        if ($parentKeyValue === null) {
            return [];
        }

        $results = $this->newQuery()
            ->where($this->foreignKey, '=', $parentKeyValue)
            ->get();

        return $this->hydrateModels($results);
    }
}
