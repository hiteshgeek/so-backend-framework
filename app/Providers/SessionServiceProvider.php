<?php

namespace App\Providers;

use Core\Container\Container;
use Core\Session\DatabaseSessionHandler;

/**
 * Session Service Provider
 *
 * Registers session handler in the container
 */
class SessionServiceProvider
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
        $this->app->singleton('session.handler', function ($app) {
            $driver = config('session.driver', 'database');

            if ($driver === 'database') {
                $db = $app->make('db');
                $table = config('session.table', 'sessions');
                $lifetime = config('session.lifetime', 120);

                return new DatabaseSessionHandler($db->connection, $table, $lifetime);
            }

            // File-based handler as fallback (though not recommended for ERP)
            return null;
        });
    }

    /**
     * Boot the service
     */
    public function boot(): void
    {
        $handler = $this->app->make('session.handler');

        if ($handler) {
            session_set_save_handler($handler, true);
        }

        // Configure session cookie parameters
        $lifetime = config('session.lifetime', 120) * 60;
        $path = '/';
        $domain = '';
        $secure = config('session.secure', false);
        $httpOnly = config('session.http_only', true);
        $sameSite = config('session.same_site', 'lax');

        session_set_cookie_params([
            'lifetime' => $lifetime,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httponly' => $httpOnly,
            'samesite' => $sameSite,
        ]);

        // Set session name
        $cookieName = config('session.cookie', 'so_session');
        session_name($cookieName);
    }
}
