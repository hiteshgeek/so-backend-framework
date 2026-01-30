<?php

namespace Core;

use Core\Container\Container;
use Core\Container\ServiceProvider;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\JsonResponse;
use Core\Exceptions\HttpException;
use Core\Exceptions\AuthenticationException;
use Core\Exceptions\AuthorizationException;
use Core\Validation\ValidationException;

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
            // Store request for isApiRequest check
            $this->instance('request', $request);

            // Get router
            $router = $this->make('router');

            // Dispatch request
            $response = $router->dispatch($request);

            // Ensure we have a Response object
            if (!$response instanceof Response) {
                $response = new Response((string) $response);
            }

            return $response;
        } catch (ValidationException $e) {
            return $this->handleValidationException($e, $request);
        } catch (AuthenticationException $e) {
            return $this->handleAuthenticationException($e, $request);
        } catch (AuthorizationException $e) {
            return $this->handleAuthorizationException($e, $request);
        } catch (HttpException $e) {
            return $this->handleHttpException($e, $request);
        } catch (\Exception $e) {
            return $this->handleException($e, $request);
        }
    }

    /**
     * Handle validation exception
     */
    protected function handleValidationException(ValidationException $e, Request $request): Response
    {
        $this->logException($e, 'notice');

        if ($this->expectsJson($request)) {
            return new JsonResponse([
                'message' => $e->getMessage(),
                'errors' => $e->getErrors(),
            ], 422);
        }

        // For web requests, redirect back with errors
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $session = $this->make('session');
        $session->flash('errors', $e->getErrors());
        $session->flash('old', $request->all());

        return new Response('', 302, ['Location' => $referer]);
    }

    /**
     * Handle authentication exception
     */
    protected function handleAuthenticationException(AuthenticationException $e, Request $request): Response
    {
        $this->logException($e, 'warning');

        if ($this->expectsJson($request)) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 401);
        }

        return new Response('', 302, ['Location' => $e->getRedirectTo()]);
    }

    /**
     * Handle authorization exception
     */
    protected function handleAuthorizationException(AuthorizationException $e, Request $request): Response
    {
        $this->logException($e, 'warning');

        if ($this->expectsJson($request)) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 403);
        }

        return $this->handleHttpException($e, $request);
    }

    /**
     * Handle HTTP exception
     */
    protected function handleHttpException(HttpException $e, ?Request $request = null): Response
    {
        $code = $e->getCode();
        $message = $e->getMessage();

        // Log HTTP errors (4xx as warning, 5xx as error)
        $this->logException($e, $code >= 500 ? 'error' : 'warning');

        // JSON response for API requests
        if ($request && $this->expectsJson($request)) {
            return new JsonResponse([
                'message' => $message ?: 'HTTP Error',
                'status' => $code,
            ], $code);
        }

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
     */
    protected function handleException(\Exception $e, ?Request $request = null): Response
    {
        // Always log unhandled exceptions
        $this->logException($e, 'error');

        // JSON response for API requests
        if ($request && $this->expectsJson($request)) {
            $data = ['message' => 'Internal Server Error', 'status' => 500];
            if ($this->make('config')->get('app.debug')) {
                $data['exception'] = get_class($e);
                $data['message'] = $e->getMessage();
                $data['file'] = $e->getFile() . ':' . $e->getLine();
                $data['trace'] = array_slice(explode("\n", $e->getTraceAsString()), 0, 10);
            }
            return new JsonResponse($data, 500);
        }

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
     * Check if the request expects a JSON response
     */
    protected function expectsJson(Request $request): bool
    {
        // Check if Request has the method
        if (method_exists($request, 'expectsJson')) {
            return $request->expectsJson();
        }

        // Fallback: check URI prefix or Accept header
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';

        return str_starts_with($uri, '/api/') || str_contains($accept, 'application/json');
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
     * Log an exception using the logger service
     *
     * @param \Exception $e
     * @param string $level
     * @return void
     */
    protected function logException(\Exception $e, string $level = 'error'): void
    {
        try {
            $logger = $this->make('logger');
            $logger->log($level, $e->getMessage(), [
                'exception' => $e,
                'url' => $_SERVER['REQUEST_URI'] ?? 'cli',
                'method' => $_SERVER['REQUEST_METHOD'] ?? 'cli',
            ]);
        } catch (\Exception $loggingException) {
            // If logger fails, write directly to file as last resort
            $msg = sprintf(
                "[%s] %s: %s in %s:%d\n",
                date('Y-m-d H:i:s'),
                strtoupper($level),
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
            @file_put_contents(
                $this->storagePath('logs/emergency.log'),
                $msg,
                FILE_APPEND | LOCK_EX
            );
        }
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
        return $this->make('config')->get('app.version', '2.0.0');
    }
}
