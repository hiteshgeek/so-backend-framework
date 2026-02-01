<?php

namespace App\Providers;

use Core\Container\Container;
use Core\Notifications\NotificationManager;
use Core\Notifications\DatabaseChannel;

/**
 * Notification Service Provider
 *
 * Registers notification services in the container
 */
class NotificationServiceProvider
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
        $this->app->singleton('notification', function ($app) {
            $manager = new NotificationManager();

            // Register database channel - use essentials database for framework notifications table
            $db = $app->make('db-essentials');
            $databaseChannel = new DatabaseChannel($db->connection);
            $manager->registerChannel('database', $databaseChannel);

            return $manager;
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
