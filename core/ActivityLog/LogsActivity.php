<?php

namespace Core\ActivityLog;

/**
 * LogsActivity Trait
 *
 * Add this trait to models that should automatically log their changes
 * to the activity_log table for audit trails
 *
 * Usage:
 * class User extends Model {
 *     use LogsActivity;
 *
 *     // Optional: customize what gets logged
 *     protected static bool $logsActivity = true;
 *     protected static array $logAttributes = ['*']; // or ['name', 'email']
 *     protected static bool $logOnlyDirty = true;
 *     protected static string $logName = 'user';
 * }
 */
trait LogsActivity
{
    /**
     * Boot the trait - register the observer
     */
    protected static function bootLogsActivity(): void
    {
        if (!static::shouldLogActivity()) {
            return;
        }

        // Register the observer
        static::observe(ActivityLogObserver::class);
    }

    /**
     * Check if activity should be logged
     */
    public static function shouldLogActivity(): bool
    {
        if (!config('activity.enabled', true)) {
            return false;
        }

        // Get logsActivity property with default value
        $reflection = new \ReflectionClass(static::class);
        if ($reflection->hasProperty('logsActivity')) {
            $property = $reflection->getProperty('logsActivity');
            $property->setAccessible(true);
            return $property->getValue();
        }

        return true; // Default: enabled
    }

    /**
     * Disable activity logging temporarily
     * Note: This method requires the model to define the $logsActivity property
     */
    public static function disableActivityLogging(): void
    {
        $reflection = new \ReflectionClass(static::class);
        if ($reflection->hasProperty('logsActivity')) {
            $property = $reflection->getProperty('logsActivity');
            $property->setAccessible(true);
            $property->setValue(false);
        }
    }

    /**
     * Enable activity logging
     * Note: This method requires the model to define the $logsActivity property
     */
    public static function enableActivityLogging(): void
    {
        $reflection = new \ReflectionClass(static::class);
        if ($reflection->hasProperty('logsActivity')) {
            $property = $reflection->getProperty('logsActivity');
            $property->setAccessible(true);
            $property->setValue(true);
        }
    }

    /**
     * Get all activities for this model instance
     */
    public function activities()
    {
        $activityModel = new Activity();

        return $activityModel->getQueryBuilder()
            ->where('subject_type', get_class($this))
            ->where('subject_id', $this->id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Get the latest activity for this model instance
     */
    public function latestActivity()
    {
        $activityModel = new Activity();

        return $activityModel->getQueryBuilder()
            ->where('subject_type', get_class($this))
            ->where('subject_id', $this->id)
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->first();
    }
}
