<?php

namespace Core\Model;

/**
 * Soft Deletes Trait
 *
 * Adds soft delete functionality to models.
 * Instead of permanently deleting records, sets a deleted_at timestamp.
 *
 * Usage:
 *   class User extends Model {
 *       use SoftDeletes;
 *   }
 *
 *   $user->delete();      // Sets deleted_at
 *   $user->restore();     // Clears deleted_at
 *   $user->forceDelete(); // Permanent delete
 *
 *   User::withTrashed()->get();  // Include deleted
 *   User::onlyTrashed()->get();  // Only deleted
 */
trait SoftDeletes
{
    /**
     * Indicates if the model is currently force deleting
     */
    protected bool $forceDeleting = false;

    /**
     * Boot the soft deletes trait
     */
    protected static function bootSoftDeletes(): void
    {
        // This method is called when the trait is used
        // Can be used to register global scopes
    }

    /**
     * Override delete to perform soft delete
     *
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->forceDeleting) {
            return $this->performDelete();
        }

        return $this->performSoftDelete();
    }

    /**
     * Perform soft delete
     *
     * @return bool
     */
    protected function performSoftDelete(): bool
    {
        $time = date('Y-m-d H:i:s');

        $this->attributes[$this->getDeletedAtColumn()] = $time;

        // Update the deleted_at timestamp
        $sql = "UPDATE {$this->getTable()} SET {$this->getDeletedAtColumn()} = ? WHERE {$this->getPrimaryKey()} = ?";

        try {
            $this->getConnection()->execute($sql, [$time, $this->attributes[$this->getPrimaryKey()]]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Restore a soft-deleted model
     *
     * @return bool
     */
    public function restore(): bool
    {
        // Clear deleted_at timestamp
        $this->attributes[$this->getDeletedAtColumn()] = null;

        $sql = "UPDATE {$this->getTable()} SET {$this->getDeletedAtColumn()} = NULL WHERE {$this->getPrimaryKey()} = ?";

        try {
            $this->getConnection()->execute($sql, [$this->attributes[$this->getPrimaryKey()]]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Force delete the model (permanent deletion)
     *
     * @return bool
     */
    public function forceDelete(): bool
    {
        $this->forceDeleting = true;

        $result = $this->delete();

        $this->forceDeleting = false;

        return $result;
    }

    /**
     * Perform actual deletion from database
     *
     * @return bool
     */
    protected function performDelete(): bool
    {
        $sql = "DELETE FROM {$this->getTable()} WHERE {$this->getPrimaryKey()} = ?";

        try {
            $this->getConnection()->execute($sql, [$this->attributes[$this->getPrimaryKey()]]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Determine if the model has been soft-deleted
     *
     * @return bool
     */
    public function trashed(): bool
    {
        return isset($this->attributes[$this->getDeletedAtColumn()]) &&
               $this->attributes[$this->getDeletedAtColumn()] !== null;
    }

    /**
     * Get the name of the "deleted at" column
     *
     * @return string
     */
    public function getDeletedAtColumn(): string
    {
        return defined('static::DELETED_AT') ? static::DELETED_AT : 'deleted_at';
    }

    /**
     * Get the fully qualified "deleted at" column
     *
     * @return string
     */
    public function getQualifiedDeletedAtColumn(): string
    {
        return $this->getTable() . '.' . $this->getDeletedAtColumn();
    }

    /**
     * Apply global scope to exclude soft-deleted records
     * This method should be called in the model's query builder
     *
     * @param string $sql
     * @return string
     */
    protected function applySoftDeleteScope(string $sql): string
    {
        // Add WHERE deleted_at IS NULL to exclude soft-deleted records
        if (!$this->isQueryIncludingTrashed($sql)) {
            $deletedAtColumn = $this->getDeletedAtColumn();

            // Check if WHERE clause exists
            if (stripos($sql, 'WHERE') !== false) {
                // Add AND condition
                $sql = str_replace('WHERE', "WHERE {$deletedAtColumn} IS NULL AND", $sql);
            } else {
                // Add WHERE clause before ORDER BY, LIMIT, etc.
                $pattern = '/(ORDER BY|LIMIT|OFFSET)/i';
                if (preg_match($pattern, $sql)) {
                    $sql = preg_replace($pattern, "WHERE {$deletedAtColumn} IS NULL $1", $sql, 1);
                } else {
                    $sql .= " WHERE {$deletedAtColumn} IS NULL";
                }
            }
        }

        return $sql;
    }

    /**
     * Check if query is including trashed records
     *
     * @param string $sql
     * @return bool
     */
    protected function isQueryIncludingTrashed(string $sql): bool
    {
        // Check if query explicitly includes trashed records
        return stripos($sql, 'WITH_TRASHED') !== false ||
               stripos($sql, 'ONLY_TRASHED') !== false;
    }

    /**
     * Static method to get all records including soft-deleted
     *
     * @return array
     */
    public static function withTrashed(): array
    {
        $instance = new static();

        $sql = "SELECT * FROM {$instance->getTable()}";

        $result = $instance->getConnection()->query($sql)->fetchAll();

        $models = [];
        foreach ($result as $row) {
            $model = new static();
            $model->fill($row);
            // Set id and deleted_at explicitly (they might be guarded)
            if (isset($row['id'])) {
                $model->setAttribute('id', $row['id']);
            }
            $deletedAtColumn = $model->getDeletedAtColumn();
            if (isset($row[$deletedAtColumn])) {
                $model->setAttribute($deletedAtColumn, $row[$deletedAtColumn]);
            }
            $model->exists = true;
            $models[] = $model;
        }

        return $models;
    }

    /**
     * Static method to get only soft-deleted records
     *
     * @return array
     */
    public static function onlyTrashed(): array
    {
        $instance = new static();

        $deletedAtColumn = $instance->getDeletedAtColumn();
        $sql = "SELECT * FROM {$instance->getTable()} WHERE {$deletedAtColumn} IS NOT NULL";

        $result = $instance->getConnection()->query($sql)->fetchAll();

        $models = [];
        foreach ($result as $row) {
            $model = new static();
            $model->fill($row);
            // Set id and deleted_at explicitly (they might be guarded)
            if (isset($row['id'])) {
                $model->setAttribute('id', $row['id']);
            }
            if (isset($row[$deletedAtColumn])) {
                $model->setAttribute($deletedAtColumn, $row[$deletedAtColumn]);
            }
            $model->exists = true;
            $models[] = $model;
        }

        return $models;
    }
}
