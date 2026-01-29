<?php

namespace Core;

use Core\Container\Container;
use Core\Container\ServiceProvider;
use Core\Http\Request;
use Core\Http\Response;
use Core\Exceptions\HttpException;

/**
 * Application Class
 *
 * Main application container and lifecycle manager
 */
class Application extends Container
{
    /**
     * Application instance (singleton)
     *
     * @var static|null
     */
    protected static ?Application $instance = null;

    /**
     * Application base path
     *
     * @var string
     */
    protected string $basePath;

    /**
     * Registered service providers
     *
     * @var array
     */
    protected array $serviceProviders = [];

    /**
     * Booted service providers
     *
     * @var array
     */
    protected array $bootedProviders = [];

    /**
     * Whether application has been bootstrapped
     *
     * @var bool
     */
    protected bool $hasBeenBootstrapped = false;

    /**
     * Constructor
     *
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/\\');

        // Set singleton instance
        static::$instance = $this;

        // Register base bindings
        $this->registerBaseBindings();
    }

    /**
     * Get application instance
     *
     * @return static
     */
    public static function getInstance(): static
    {
        return static::$instance;
    }

    /**
     * Register base bindings
     *
     * @return void
     */
    protected function registerBaseBindings(): void
    {
        // Bind application instance
        $this->instance('app', $this);
        $this->instance(Application::class, $this);
        $this->instance(Container::class, $this);
    }

    /**
     * Get base path
     *
     * @param string $path
     * @return string
     */
    public function basePath(string $path = ''): string
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Get config path
     *
     * @param string $path
     * @return string
     */
    public function configPath(string $path = ''): string
    {
        return $this->basePath('config' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }

    /**
     * Get storage path
     *
     * @param string $path
     * @return string
     */
    public function storagePath(string $path = ''): string
    {
        return $this->basePath('storage' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }

    /**
     * Get public path
     *
     * @param string $path
     * @return string
     */
    public function publicPath(string $path = ''): string
    {
        return $this->basePath('public' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }

    /**
     * Register a service provider
     *
     * @param ServiceProvider $provider
     * @return void
     */
    public function register(ServiceProvider $provider): void
    {
        // Register the provider
        $provider->register();

        // Store provider
        $this->serviceProviders[] = $provider;

        // Boot if already bootstrapped
        if ($this->hasBeenBootstrapped) {
            $this->bootProvider($provider);
        }
    }

    /**
     * Boot all service providers
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->hasBeenBootstrapped) {
            return;
        }

        foreach ($this->serviceProviders as $provider) {
            $this->bootProvider($provider);
        }

        $this->hasBeenBootstrapped = true;
    }

    /**
     * Boot a service provider
     *
     * @param ServiceProvider $provider
     * @return void
     */
    protected function bootProvider(ServiceProvider $provider): void
    {
        $provider->boot();
        $this->bootedProviders[] = $provider;
    }

    /**
     * Handle web request
     *
     * @param Request $request
     * @return Response
     */
    public function handleWebRequest(Request $request): Response
    {
        try {
            // Get router
            $router = $this->make('router');

            // Dispatch request
            $response = $router->dispatch($request);

            // Ensure we have a Response object
            if (!$response instanceof Response) {
                $response = new Response((string) $response);
            }

            return $response;
        } catch (HttpException $e) {
            return $this->handleHttpException($e);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Handle HTTP exception
     *
     * @param HttpException $e
     * @return Response
     */
    protected function handleHttpException(HttpException $e): Response
    {
        $code = $e->getCode();
        $message = $e->getMessage();

        // Check if error view exists
        $viewPath = $this->basePath("resources/views/errors/{$code}.php");

        if (file_exists($viewPath)) {
            ob_start();
            extract(['code' => $code, 'message' => $message]);
            require $viewPath;
            $content = ob_get_clean();

            return new Response($content, $code);
        }

        // Default error response
        return new Response(
            "<html><body><h1>Error {$code}</h1><p>{$message}</p></body></html>",
            $code
        );
    }

    /**
     * Handle general exception
     *
     * @param \Exception $e
     * @return Response
     */
    protected function handleException(\Exception $e): Response
    {
        // In debug mode, show full error
        if ($this->make('config')->get('app.debug')) {
            $content = $this->formatDebugError($e);
            return new Response($content, 500);
        }

        // Production error response
        return new Response(
            "<html><body><h1>Error 500</h1><p>Internal Server Error</p></body></html>",
            500
        );
    }

    /**
     * Format debug error
     *
     * @param \Exception $e
     * @return string
     */
    protected function formatDebugError(\Exception $e): string
    {
        $message = htmlspecialchars($e->getMessage());
        $file = htmlspecialchars($e->getFile());
        $line = $e->getLine();
        $trace = htmlspecialchars($e->getTraceAsString());

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .error { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #d32f2f; margin-top: 0; }
        .file { color: #666; margin: 10px 0; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="error">
        <h1>Exception</h1>
        <p><strong>{$message}</strong></p>
        <div class="file">
            <strong>File:</strong> {$file} <strong>Line:</strong> {$line}
        </div>
        <h3>Stack Trace:</h3>
        <pre>{$trace}</pre>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Terminate application
     *
     * @return void
     */
    public function terminate(): void
    {
        // Perform cleanup tasks
    }

    /**
     * Check if application is in console mode
     *
     * @return bool
     */
    public function isConsole(): bool
    {
        return php_sapi_name() === 'cli' || php_sapi_name() === 'phpdbg';
    }

    /**
     * Check if application is in debug mode
     *
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->make('config')->get('app.debug', false);
    }

    /**
     * Get application version
     *
     * @return string
     */
    public function version(): string
    {
        return '1.0.0';
    }
}
