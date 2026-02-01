<?php

namespace Core\ActivityLog;

use Core\Model\Model;

/**
 * Activity Model
 *
 * Represents an entry in the activity_log table for audit trails
 */
class Activity extends Model
{
    protected static string $table = 'activity_log';

    protected array $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'event',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
    ];

    protected array $casts = [
        'properties' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Override query to use essentials database for activity_log table
     */
    public static function query(): \Core\Database\QueryBuilder
    {
        return app('db-essentials')->table(static::$table);
    }

    /**
     * Get the properties as an array
     */
    public function getProperties(): array
    {
        return is_string($this->properties)
            ? json_decode($this->properties, true) ?? []
            : ($this->properties ?? []);
    }

    /**
     * Get the changes from properties
     */
    public function getChanges(): array
    {
        $properties = $this->getProperties();
        return $properties['attributes'] ?? [];
    }

    /**
     * Get the old values from properties
     */
    public function getOldValues(): array
    {
        $properties = $this->getProperties();
        return $properties['old'] ?? [];
    }

    /**
     * Get the causer (user who performed the action)
     */
    public function getCauser(): ?Model
    {
        if (!$this->causer_type || !$this->causer_id) {
            return null;
        }

        $causerClass = $this->causer_type;
        if (!class_exists($causerClass)) {
            return null;
        }

        return $causerClass::find($this->causer_id);
    }

    /**
     * Get the subject (model that was acted upon)
     */
    public function getSubject(): ?Model
    {
        if (!$this->subject_type || !$this->subject_id) {
            return null;
        }

        $subjectClass = $this->subject_type;
        if (!class_exists($subjectClass)) {
            return null;
        }

        return $subjectClass::find($this->subject_id);
    }

    /**
     * Scope to filter by log name
     */
    public function scopeInLog($query, string $logName)
    {
        return $query->where('log_name', $logName);
    }

    /**
     * Scope to filter by causer
     */
    public function scopeCausedBy($query, Model $causer)
    {
        return $query->where('causer_type', get_class($causer))
                     ->where('causer_id', $causer->id);
    }

    /**
     * Scope to filter by subject
     */
    public function scopeForSubject($query, Model $subject)
    {
        return $query->where('subject_type', get_class($subject))
                     ->where('subject_id', $subject->id);
    }

    /**
     * Scope to filter by event
     */
    public function scopeForEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope to get activities within a batch
     */
    public function scopeInBatch($query, string $batchUuid)
    {
        return $query->where('batch_uuid', $batchUuid);
    }
}
