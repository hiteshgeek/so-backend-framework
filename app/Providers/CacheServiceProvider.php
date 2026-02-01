<?php

namespace App\Providers;

use Core\Container\Container;
use Core\Cache\CacheManager;

/**
 * Cache Service Provider
 *
 * Registers cache services in the container
 */
class CacheServiceProvider
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
        $this->app->singleton('cache', function ($app) {
            // Use essentials database for framework cache tables
            $db = $app->make('db-essentials');
            $config = $app->make('config')->get('cache');

            return new CacheManager($db->connection, $config);
        });
    }

    /**
     * Boot the service
     */
    public function boot(): void
    {
        // Can be used for additional setup
    }
}
