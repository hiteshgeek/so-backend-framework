<?php

namespace Core\Http;

/**
 * HTTP Request
 *
 * Represents an HTTP request
 */
class Request
{
    protected array $query;
    protected array $request;
    protected array $server;
    protected array $files;
    protected array $cookies;
    protected array $headers;
    protected ?string $content = null;
    protected array $attributes = [];

    public function __construct(
        array $query = [],
        array $request = [],
        array $server = [],
        array $files = [],
        array $cookies = []
    ) {
        $this->query = $query;
        $this->request = $request;
        $this->server = $server;
        $this->files = $files;
        $this->cookies = $cookies;
        $this->headers = $this->parseHeaders();
    }

    public static function createFromGlobals(): static
    {
        $request = $_POST;

        // Parse JSON request body if Content-Type is application/json
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $jsonData = json_decode(file_get_contents('php://input'), true);
            if (is_array($jsonData)) {
                $request = $jsonData;
            }
        }

        return new static($_GET, $request, $_SERVER, $_FILES, $_COOKIE);
    }

    protected function parseHeaders(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $header = str_replace('_', '-', substr($key, 5));
                $headers[$header] = $value;
            } elseif (in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH'])) {
                $header = str_replace('_', '-', $key);
                $headers[$header] = $value;
            }
        }
        return $headers;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->request[$key] ?? $this->query[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->query, $this->request);
    }

    public function only(array $keys): array
    {
        $results = [];
        foreach ($keys as $key) {
            $results[$key] = $this->input($key);
        }
        return $results;
    }

    public function except(array $keys): array
    {
        $inputs = $this->all();
        foreach ($keys as $key) {
            unset($inputs[$key]);
        }
        return $inputs;
    }

    public function has(string $key): bool
    {
        return isset($this->request[$key]) || isset($this->query[$key]);
    }

    public function method(): string
    {
        $method = strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');

        // Support HTTP method spoofing via _method field for DELETE/PUT/PATCH
        if ($method === 'POST') {
            $spoofed = $this->input('_method');
            if ($spoofed && in_array(strtoupper($spoofed), ['PUT', 'DELETE', 'PATCH'])) {
                return strtoupper($spoofed);
            }
        }

        return $method;
    }

    public function isMethod(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }

    public function uri(): string
    {
        $uri = strtok($this->server['REQUEST_URI'] ?? '/', '?');

        // Strip base path from URI if running in subdirectory
        $basePath = $this->getBasePath();
        if ($basePath && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        return $uri ?: '/';
    }

    protected function getBasePath(): string
    {
        // Get base path from SCRIPT_NAME (e.g., /so-backend-framework/public/index.php)
        $scriptName = $this->server['SCRIPT_NAME'] ?? '';
        $basePath = dirname($scriptName);

        // If we're in /public, strip that from the base path
        if (str_ends_with($basePath, '/public')) {
            $basePath = substr($basePath, 0, -7);
        }

        return rtrim($basePath, '/');
    }

    public function fullUrl(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    public function header(string $key, mixed $default = null): mixed
    {
        // Normalize to uppercase with hyphens (matching parseHeaders format)
        $key = strtoupper(str_replace('_', '-', $key));
        return $this->headers[$key] ?? $default;
    }

    public function bearerToken(): ?string
    {
        $header = $this->header('AUTHORIZATION');
        if ($header && preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function ip(): string
    {
        return $this->server['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    public function userAgent(): ?string
    {
        return $this->server['HTTP_USER_AGENT'] ?? null;
    }

    public function getContent(): string
    {
        if ($this->content === null) {
            $this->content = file_get_contents('php://input');
        }
        return $this->content;
    }

    public function json(): ?array
    {
        return json_decode($this->getContent(), true);
    }

    public function file(string $key): ?UploadedFile
    {
        if (!isset($this->files[$key])) {
            return null;
        }
        return new UploadedFile($this->files[$key]);
    }

    public function session(): Session
    {
        return app('session');
    }

    public function user(): mixed
    {
        return $this->get('user');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->attributes[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Magic getter for dynamic properties
     */
    public function __get(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Magic setter for dynamic properties
     */
    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Magic isset for dynamic properties
     */
    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Check if the request expects a JSON response
     *
     * @return bool
     */
    public function expectsJson(): bool
    {
        // Check Accept header
        $accept = $this->header('ACCEPT', '');
        if (str_contains($accept, 'application/json')) {
            return true;
        }

        // Check Content-Type header
        $contentType = $this->header('CONTENT-TYPE', '');
        if (str_contains($contentType, 'application/json')) {
            return true;
        }

        // Check if URI starts with /api/
        if (str_starts_with($this->uri(), '/api/')) {
            return true;
        }

        return false;
    }

    /**
     * Check if the request is an AJAX request
     *
     * @return bool
     */
    public function ajax(): bool
    {
        return $this->header('X-REQUESTED-WITH') === 'XMLHttpRequest';
    }

    /**
     * Check if the request wants JSON
     *
     * @return bool
     */
    public function wantsJson(): bool
    {
        return $this->expectsJson();
    }
}
