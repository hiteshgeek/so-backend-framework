<?php

namespace App\Providers;

use Core\Container\Container;
use Core\ActivityLog\ActivityLogger;

/**
 * Activity Log Service Provider
 *
 * Registers the activity logging service in the container
 */
class ActivityLogServiceProvider
{
    protected Container $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Register the service in the container
     */
    public function register(): void
    {
        $this->app->singleton('activity.logger', function ($app) {
            $db = $app->make('db');
            return new ActivityLogger($db->connection);
        });
    }

    /**
     * Boot the service (called after all providers are registered)
     */
    public function boot(): void
    {
        // Can be used for additional setup after all services are registered
    }
}
