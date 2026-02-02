<?php

use Core\Application;
use Core\Support\Env;
use Core\Support\Config;
use Core\Database\Connection;
use Core\Database\QueryBuilder;
use Core\Http\Session;
use Core\Routing\Router;

// Load environment variables
Env::load(__DIR__ . '/../.env');

// Create application instance
$app = new Application(__DIR__ . '/..');

// Bind core services
$app->singleton('config', function ($app) {
    return new Config($app->configPath());
});

$app->singleton('db', function ($app) {
    $config = $app->make('config');
    $connection = $config->get('database.default');
    $connectionConfig = $config->get("database.connections.{$connection}");

    $dbConnection = new Connection($connectionConfig);

    // Return an object that can create query builders
    return new class($dbConnection) {
        public $connection;

        public function __construct($connection) {
            $this->connection = $connection;
        }

        public function table(string $table): QueryBuilder {
            $builder = new QueryBuilder($this->connection);
            return $builder->table($table);
        }

        public function lastInsertId(): string {
            return $this->connection->lastInsertId();
        }

        public function execute(string $sql, array $params = []): int {
            return $this->connection->query($sql, $params)->rowCount();
        }

        public function query(string $sql, array $params = []): \PDOStatement {
            return $this->connection->query($sql, $params);
        }
    };
});

$app->singleton('db-essentials', function ($app) {
    $config = $app->make('config');
    $connectionConfig = $config->get("database.connections.essentials");

    $dbConnection = new Connection($connectionConfig);

    // Return an object that can create query builders for essentials database
    return new class($dbConnection) {
        public $connection;

        public function __construct($connection) {
            $this->connection = $connection;
        }

        public function table(string $table): QueryBuilder {
            $builder = new QueryBuilder($this->connection);
            return $builder->table($table);
        }

        public function lastInsertId(): string {
            return $this->connection->lastInsertId();
        }

        public function execute(string $sql, array $params = []): int {
            return $this->connection->query($sql, $params)->rowCount();
        }

        public function query(string $sql, array $params = []): \PDOStatement {
            return $this->connection->query($sql, $params);
        }
    };
});

$app->singleton('encrypter', function ($app) {
    $config = $app->make('config');
    $key = $config->get('app.key', '');

    return new \Core\Security\Encrypter($key);
});

$app->singleton('session', function ($app) {
    return new Session();
});

$app->singleton('router', function ($app) {
    return new Router();
});

// Register middleware aliases
Router::middlewareAlias('auth', \App\Middleware\AuthMiddleware::class);
Router::middlewareAlias('guest', \App\Middleware\GuestMiddleware::class);
Router::middlewareAlias('throttle', \App\Middleware\ThrottleMiddleware::class);
Router::middlewareAlias('csrf', \App\Middleware\CsrfMiddleware::class);
Router::middlewareAlias('cors', \App\Middleware\CorsMiddleware::class);
Router::middlewareAlias('jwt', \App\Middleware\JwtMiddleware::class);

$app->singleton('auth', function ($app) {
    // Create login throttle instance with config
    $throttleConfig = $app->make('config')->get('auth.login_throttle', []);
    $throttle = null;

    if (!empty($throttleConfig['enabled'])) {
        try {
            $cache = $app->make('cache');
            $throttle = new \Core\Auth\LoginThrottle($cache, $throttleConfig);
        } catch (\Exception $e) {
            // Cache not available - throttle will be null
        }
    }

    return new \Core\Auth\Auth($app->make('session'), $throttle);
});

$app->singleton('csrf', function ($app) {
    return new \Core\Security\Csrf($app->make('session'));
});

$app->singleton('assets', function ($app) {
    $config = $app->make('config');
    return new \Core\Support\AssetManager(
        $config->get('app.asset_url', ''),
        $config->get('app.asset_versioning', true)
    );
});

$app->singleton('logger', function ($app) {
    $config = $app->make('config')->get('logging', []);
    return new \Core\Logging\Logger($config);
});

$app->singleton('events', function ($app) {
    return new \Core\Events\EventDispatcher();
});

// Register service providers from config
$providers = $app->make('config')->get('app.providers', []);
$providerInstances = [];

foreach ($providers as $providerClass) {
    $provider = new $providerClass($app);
    $provider->register();
    $providerInstances[] = $provider;
}

// Boot service providers
foreach ($providerInstances as $provider) {
    if (method_exists($provider, 'boot')) {
        $provider->boot();
    }
}

// Boot application
$app->boot();

return $app;
