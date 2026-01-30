<?php

namespace Core\Mail;

use Core\Container\Container;

/**
 * Mail Service Provider
 *
 * Registers the Mailer singleton in the application container.
 * Follows the same pattern as CacheServiceProvider and other
 * framework providers that accept a Container instance.
 */
class MailServiceProvider
{
    /**
     * Application container
     *
     * @var Container
     */
    protected Container $app;

    /**
     * Constructor
     *
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Register the mailer service in the container
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('mailer', function ($app) {
            $config = $app->make('config')->get('mail');
            return new Mailer($config);
        });
    }

    /**
     * Boot the service
     *
     * @return void
     */
    public function boot(): void
    {
        // Can be used for additional setup after all services are registered
    }
}
