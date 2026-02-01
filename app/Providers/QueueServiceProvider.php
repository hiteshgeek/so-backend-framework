<?php

namespace App\Providers;

use Core\Container\Container;
use Core\Queue\QueueManager;
use Core\Queue\Worker;

/**
 * Queue Service Provider
 *
 * Registers queue services in the container
 */
class QueueServiceProvider
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
        $this->app->singleton('queue', function ($app) {
            // Use essentials database for framework queue tables
            $db = $app->make('db-essentials');
            $config = $app->make('config')->get('queue');

            return new QueueManager($db->connection, $config);
        });

        $this->app->singleton('queue.worker', function ($app) {
            return new Worker($app->make('queue'));
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
