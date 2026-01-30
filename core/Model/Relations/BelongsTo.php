<?php

namespace Core\Model\Relations;

use Core\Model\Model;

/**
 * BelongsTo Relationship
 *
 * Represents the inverse of a one-to-one or one-to-many relationship.
 * The foreign key resides on the current (child) model's table, pointing
 * to the owner (parent) model.
 *
 * Usage:
 *   // In Post model:
 *   public function user(): BelongsTo
 *   {
 *       return $this->belongsTo(User::class, 'user_id', 'id');
 *   }
 *
 *   // Access:
 *   $post->user; // Returns User model or null
 *
 * Note: In BelongsTo, the key semantics are inverted compared to HasOne/HasMany:
 *   - foreignKey  = column on the CHILD (current) model's table (e.g. posts.user_id)
 *   - localKey    = column on the PARENT (related/owner) model's table (e.g. users.id)
 *     (referred to as "ownerKey" in the Model convenience method)
 */
class BelongsTo extends Relation
{
    /**
     * Execute the relationship query.
     *
     * Looks up the parent/owner record by reading the foreign key value
     * from the current (child) model and matching it against the owner's
     * primary key (localKey).
     *
     * SQL equivalent:
     *   SELECT * FROM {related_table}
     *   WHERE {owner_key} = {child.foreign_key_value}
     *   LIMIT 1
     *
     * @return Model|null The parent/owner model instance, or null if none found
     */
    public function get(): mixed
    {
        // In BelongsTo, the foreign key is on the child (parent model instance here),
        // and the local key (ownerKey) is on the related (owner) model's table.
        $foreignKeyValue = $this->parent->getAttribute($this->foreignKey);

        if ($foreignKeyValue === null) {
            return null;
        }

        $result = $this->newQuery()
            ->where($this->localKey, '=', $foreignKeyValue)
            ->first();

        if ($result === null) {
            return null;
        }

        return $this->hydrateModel($result);
    }
}
