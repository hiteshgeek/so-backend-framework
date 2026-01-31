<?php

namespace App\Providers;

use Core\Container\Container;
use Core\Session\DatabaseSessionHandler;
use Core\Session\AuserSessionHandler;
use App\Constants\DatabaseTables;

/**
 * Session Service Provider
 *
 * Registers session handler in the container
 * Uses custom AuserSessionHandler for existing auser_session table
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
                // Use main database connection (not essentials) for auser_session table
                $db = $app->make('db');
                $table = DatabaseTables::AUSER_SESSION;  // Use existing auser_session table
                $lifetime = config('session.lifetime', 120);

                // Check if session encryption is enabled
                $encrypt = config('session.encrypt', false);
                $encrypter = null;

                if ($encrypt) {
                    // Get the encrypter instance (requires APP_KEY to be set)
                    try {
                        $encrypter = $app->make('encrypter');
                    } catch (\Exception $e) {
                        // Encrypter not available - proceed without encryption
                        $encrypt = false;
                    }
                }

                // Use custom AuserSessionHandler for existing auser_session table
                return new AuserSessionHandler($db->connection, $table, $lifetime, $encrypter, $encrypt);
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
