<?php

namespace Core\Container;

use Core\Application;

/**
 * Service Provider Base Class
 *
 * Provides services to the application container
 */
abstract class ServiceProvider
{
    /**
     * Application instance
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Constructor
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register services
     *
     * @return void
     */
    abstract public function register(): void;

    /**
     * Bootstrap services
     *
     * @return void
     */
    public function boot(): void
    {
        // Optional boot method
    }
}
