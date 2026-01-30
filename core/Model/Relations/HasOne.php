<?php

namespace Core\Model\Relations;

use Core\Model\Model;

/**
 * HasOne Relationship
 *
 * Represents a one-to-one relationship where the parent model
 * owns exactly one instance of the related model. The foreign key
 * resides on the related model's table.
 *
 * Usage:
 *   // In User model:
 *   public function profile(): HasOne
 *   {
 *       return $this->hasOne(Profile::class, 'user_id', 'id');
 *   }
 *
 *   // Access:
 *   $user->profile; // Returns Profile model or null
 */
class HasOne extends Relation
{
    /**
     * Execute the relationship query.
     *
     * Fetches the first related record where the foreign key matches
     * the parent model's local key value.
     *
     * SQL equivalent:
     *   SELECT * FROM {related_table}
     *   WHERE {foreign_key} = {parent.local_key}
     *   LIMIT 1
     *
     * @return Model|null The related model instance, or null if none found
     */
    public function get(): mixed
    {
        $parentKeyValue = $this->getParentKeyValue();

        if ($parentKeyValue === null) {
            return null;
        }

        $result = $this->newQuery()
            ->where($this->foreignKey, '=', $parentKeyValue)
            ->first();

        if ($result === null) {
            return null;
        }

        return $this->hydrateModel($result);
    }
}
