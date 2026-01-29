<?php

namespace Core\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Twig\TwigFunction;

/**
 * View Service with Twig
 *
 * Provides template rendering with Twig engine
 */
class View
{
    protected Environment $twig;
    protected string $viewsPath;
    protected string $cachePath;

    public function __construct(string $viewsPath, string $cachePath, bool $debug = false)
    {
        $this->viewsPath = $viewsPath;
        $this->cachePath = $cachePath;

        // Initialize Twig
        $loader = new FilesystemLoader($this->viewsPath);

        $this->twig = new Environment($loader, [
            'cache' => $debug ? false : $this->cachePath,
            'debug' => $debug,
            'auto_reload' => $debug,
            'autoescape' => 'html', // Automatic XSS protection
            'strict_variables' => $debug,
        ]);

        if ($debug) {
            $this->twig->addExtension(new DebugExtension());
        }

        // Add custom functions
        $this->registerFunctions();
    }

    /**
     * Register custom Twig functions
     */
    protected function registerFunctions(): void
    {
        // url() function
        $this->twig->addFunction(new TwigFunction('url', function ($path = '') {
            return url($path);
        }));

        // route() function
        $this->twig->addFunction(new TwigFunction('route', function ($name, $params = []) {
            return route($name, $params);
        }));

        // csrf_field() function
        $this->twig->addFunction(new TwigFunction('csrf_field', function () {
            return csrf_field();
        }, ['is_safe' => ['html']]));

        // csrf_token() function
        $this->twig->addFunction(new TwigFunction('csrf_token', function () {
            return csrf_token();
        }));

        // old() function
        $this->twig->addFunction(new TwigFunction('old', function ($key, $default = null) {
            return old($key, $default);
        }));

        // session() function
        $this->twig->addFunction(new TwigFunction('session', function ($key = null, $default = null) {
            return session($key, $default);
        }));

        // auth() function
        $this->twig->addFunction(new TwigFunction('auth', function () {
            return auth();
        }));

        // config() function
        $this->twig->addFunction(new TwigFunction('config', function ($key, $default = null) {
            return config($key, $default);
        }));

        // asset() function for static files
        $this->twig->addFunction(new TwigFunction('asset', function ($path) {
            return url('/assets/' . ltrim($path, '/'));
        }));
    }

    /**
     * Render a template
     */
    public function render(string $template, array $data = []): string
    {
        // Convert dot notation to directory separator
        $template = str_replace('.', '/', $template) . '.twig';

        return $this->twig->render($template, $data);
    }

    /**
     * Add a global variable to all templates
     */
    public function addGlobal(string $name, mixed $value): void
    {
        $this->twig->addGlobal($name, $value);
    }

    /**
     * Get Twig environment instance
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }
}
