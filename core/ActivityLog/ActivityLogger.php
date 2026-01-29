<?php

namespace Core\ActivityLog;

use Core\Model\Model;
use Core\Database\Connection;

/**
 * Activity Logger Service
 *
 * Provides fluent API for logging user activities and model changes
 * Essential for ERP compliance and audit trails
 */
class ActivityLogger
{
    protected ?string $logName = null;
    protected ?string $description = null;
    protected ?Model $subject = null;
    protected ?string $event = null;
    protected ?Model $causer = null;
    protected array $properties = [];
    protected ?string $batchUuid = null;
    protected Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
        $this->logName = config('activity.log_name', 'default');
    }

    /**
     * Set the log description
     */
    public function log(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set the subject (model being acted upon)
     */
    public function performedOn(Model $model): self
    {
        $this->subject = $model;
        return $this;
    }

    /**
     * Set the causer (user performing the action)
     */
    public function causedBy(?Model $causer): self
    {
        $this->causer = $causer;
        return $this;
    }

    /**
     * Set custom properties
     */
    public function withProperties(array $properties): self
    {
        $this->properties = array_merge($this->properties, $properties);
        return $this;
    }

    /**
     * Set the event type
     */
    public function event(string $event): self
    {
        $this->event = $event;
        return $this;
    }

    /**
     * Set the log name
     */
    public function inLog(string $logName): self
    {
        $this->logName = $logName;
        return $this;
    }

    /**
     * Set the batch UUID for grouping related activities
     */
    public function withBatch(string $batchUuid): self
    {
        $this->batchUuid = $batchUuid;
        return $this;
    }

    /**
     * Save the activity log
     */
    public function save(): Activity
    {
        $activityModel = new Activity();

        $attributes = [
            'log_name' => $this->logName,
            'description' => $this->description,
            'subject_type' => $this->subject ? get_class($this->subject) : null,
            'subject_id' => $this->subject?->id ?? null,
            'event' => $this->event,
            'causer_type' => $this->causer ? get_class($this->causer) : null,
            'causer_id' => $this->causer?->id ?? null,
            'properties' => !empty($this->properties) ? json_encode($this->properties) : null,
            'batch_uuid' => $this->batchUuid,
        ];

        foreach ($attributes as $key => $value) {
            $activityModel->$key = $value;
        }

        $activityModel->save();

        // Reset for next log
        $this->reset();

        return $activityModel;
    }

    /**
     * Log model changes automatically
     *
     * This method is called by the LogsActivity trait
     */
    public function logModelChanges(Model $model, string $event): void
    {
        if (!config('activity.enabled', true)) {
            return;
        }

        // Get the attributes to log
        $logAttributes = $this->getLogAttributes($model);

        // Determine what changed
        $properties = $this->getChangedProperties($model, $event, $logAttributes);

        // Skip if no changes (for update events with logOnlyDirty)
        if ($event === 'updated' && empty($properties['attributes'])) {
            return;
        }

        // Build description
        $description = $this->buildDescription($model, $event);

        // Create the log entry
        $this->log($description)
            ->performedOn($model)
            ->causedBy($this->getCauserFromAuth())
            ->withProperties($properties)
            ->event($event)
            ->inLog($this->getModelLogName($model))
            ->save();
    }

    /**
     * Get attributes that should be logged for a model
     */
    protected function getLogAttributes(Model $model): array
    {
        // Check if model has logAttributes property
        $reflection = new \ReflectionClass($model);

        if ($reflection->hasProperty('logAttributes')) {
            $property = $reflection->getProperty('logAttributes');
            $property->setAccessible(true);
            $logAttributes = $property->getValue($model);

            if (in_array('*', $logAttributes)) {
                return array_keys($model->getAttributes());
            }

            return $logAttributes;
        }

        // Default: log all attributes
        return array_keys($model->getAttributes());
    }

    /**
     * Get changed properties for logging
     */
    protected function getChangedProperties(Model $model, string $event, array $logAttributes): array
    {
        $properties = [];

        switch ($event) {
            case 'created':
                $properties['attributes'] = $this->filterAttributes(
                    $model->getAttributes(),
                    $logAttributes
                );
                break;

            case 'updated':
                $dirty = $model->getDirty();
                $original = $model->getOriginal();

                // Check if logOnlyDirty is set
                $logOnlyDirty = $this->shouldLogOnlyDirty($model);

                if ($logOnlyDirty) {
                    $attributes = $this->filterAttributes($dirty, $logAttributes);
                    $old = [];
                    foreach (array_keys($attributes) as $key) {
                        if (isset($original[$key])) {
                            $old[$key] = $original[$key];
                        }
                    }
                } else {
                    $attributes = $this->filterAttributes($model->getAttributes(), $logAttributes);
                    $old = $this->filterAttributes($original, $logAttributes);
                }

                $properties['attributes'] = $attributes;
                if (!empty($old)) {
                    $properties['old'] = $old;
                }
                break;

            case 'deleted':
                $properties['attributes'] = $this->filterAttributes(
                    $model->getAttributes(),
                    $logAttributes
                );
                break;
        }

        return $properties;
    }

    /**
     * Check if model should only log dirty attributes
     */
    protected function shouldLogOnlyDirty(Model $model): bool
    {
        $reflection = new \ReflectionClass($model);

        if ($reflection->hasProperty('logOnlyDirty')) {
            $property = $reflection->getProperty('logOnlyDirty');
            $property->setAccessible(true);
            return $property->getValue($model);
        }

        return true; // Default: log only dirty
    }

    /**
     * Filter attributes to only those that should be logged
     */
    protected function filterAttributes(array $attributes, array $logAttributes): array
    {
        if (empty($logAttributes)) {
            return [];
        }

        $filtered = [];
        foreach ($logAttributes as $attr) {
            if (isset($attributes[$attr])) {
                $filtered[$attr] = $attributes[$attr];
            }
        }

        return $filtered;
    }

    /**
     * Build a description for the activity
     */
    protected function buildDescription(Model $model, string $event): string
    {
        $modelName = class_basename($model);

        return match($event) {
            'created' => "{$modelName} created",
            'updated' => "{$modelName} updated",
            'deleted' => "{$modelName} deleted",
            'restored' => "{$modelName} restored",
            default => "{$modelName} {$event}",
        };
    }

    /**
     * Get the log name for a model
     */
    protected function getModelLogName(Model $model): string
    {
        $reflection = new \ReflectionClass($model);

        if ($reflection->hasProperty('logName')) {
            $property = $reflection->getProperty('logName');
            $property->setAccessible(true);
            return $property->getValue($model);
        }

        return $this->logName ?? 'default';
    }

    /**
     * Get the causer from the authenticated user
     */
    protected function getCauserFromAuth(): ?Model
    {
        return auth()->user();
    }

    /**
     * Reset the logger state for next log
     */
    protected function reset(): void
    {
        $this->description = null;
        $this->subject = null;
        $this->event = null;
        $this->causer = null;
        $this->properties = [];
        $this->batchUuid = null;
        $this->logName = config('activity.log_name', 'default');
    }

    /**
     * Static helper for quick logging
     */
    public static function create(string $description): self
    {
        $instance = app('activity.logger');
        return $instance->log($description);
    }
}
