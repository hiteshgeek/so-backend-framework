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
    };
});

$app->singleton('session', function ($app) {
    return new Session();
});

$app->singleton('router', function ($app) {
    return new Router();
});

$app->singleton('auth', function ($app) {
    return new \Core\Auth\Auth($app->make('session'));
});

$app->singleton('csrf', function ($app) {
    return new \Core\Security\Csrf($app->make('session'));
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
