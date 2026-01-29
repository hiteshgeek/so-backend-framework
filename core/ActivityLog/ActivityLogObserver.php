<?php

namespace Core\ActivityLog;

use Core\Model\Model;

/**
 * Activity Log Observer
 *
 * Observes model events and logs them automatically
 * Works with models that use the LogsActivity trait
 */
class ActivityLogObserver
{
    protected ActivityLogger $logger;

    public function __construct()
    {
        $this->logger = app('activity.logger');
    }

    /**
     * Handle the model "created" event
     */
    public function created(Model $model): void
    {
        $this->logger->logModelChanges($model, 'created');
    }

    /**
     * Handle the model "updated" event
     */
    public function updated(Model $model): void
    {
        $this->logger->logModelChanges($model, 'updated');
    }

    /**
     * Handle the model "deleted" event
     */
    public function deleted(Model $model): void
    {
        $this->logger->logModelChanges($model, 'deleted');
    }

    /**
     * Handle the model "restored" event (if soft deletes are implemented)
     */
    public function restored(Model $model): void
    {
        $this->logger->logModelChanges($model, 'restored');
    }
}
