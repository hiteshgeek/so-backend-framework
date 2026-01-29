<?php

namespace Core\Api;

/**
 * Internal API Client
 *
 * Unified client for making internal API calls with automatic authentication.
 * Supports signature-based authentication for secure internal communication.
 *
 * Usage:
 *   $client = new ApiClient();
 *   $response = $client->get('/api/users');
 *   $response = $client->post('/api/users', ['name' => 'John']);
 */
class ApiClient
{
    /**
     * Base URL for API calls
     */
    protected string $baseUrl;

    /**
     * Internal API Guard for authentication
     */
    protected ?InternalApiGuard $guard = null;

    /**
     * Default headers
     */
    protected array $headers = [];

    /**
     * Timeout in seconds
     */
    protected int $timeout = 30;

    /**
     * Constructor
     *
     * @param string|null $baseUrl Base URL (from config if not provided)
     * @param InternalApiGuard|null $guard API guard instance
     */
    public function __construct(?string $baseUrl = null, ?InternalApiGuard $guard = null)
    {
        $this->baseUrl = $baseUrl ?? config('app.url', 'http://localhost');
        $this->guard = $guard;

        // Set default headers
        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Make GET request
     *
     * @param string $uri Request URI
     * @param array $query Query parameters
     * @param array $headers Additional headers
     * @return array Response data
     */
    public function get(string $uri, array $query = [], array $headers = []): array
    {
        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        return $this->request('GET', $uri, null, $headers);
    }

    /**
     * Make POST request
     *
     * @param string $uri Request URI
     * @param array $data Request body data
     * @param array $headers Additional headers
     * @return array Response data
     */
    public function post(string $uri, array $data = [], array $headers = []): array
    {
        return $this->request('POST', $uri, $data, $headers);
    }

    /**
     * Make PUT request
     *
     * @param string $uri Request URI
     * @param array $data Request body data
     * @param array $headers Additional headers
     * @return array Response data
     */
    public function put(string $uri, array $data = [], array $headers = []): array
    {
        return $this->request('PUT', $uri, $data, $headers);
    }

    /**
     * Make DELETE request
     *
     * @param string $uri Request URI
     * @param array $headers Additional headers
     * @return array Response data
     */
    public function delete(string $uri, array $headers = []): array
    {
        return $this->request('DELETE', $uri, null, $headers);
    }

    /**
     * Make PATCH request
     *
     * @param string $uri Request URI
     * @param array $data Request body data
     * @param array $headers Additional headers
     * @return array Response data
     */
    public function patch(string $uri, array $data = [], array $headers = []): array
    {
        return $this->request('PATCH', $uri, $data, $headers);
    }

    /**
     * Make HTTP request
     *
     * @param string $method HTTP method
     * @param string $uri Request URI
     * @param array|null $data Request body data
     * @param array $headers Additional headers
     * @return array Response data
     * @throws \Exception
     */
    protected function request(string $method, string $uri, ?array $data = null, array $headers = []): array
    {
        $url = $this->buildUrl($uri);
        $body = $data ? json_encode($data) : '';

        // Merge headers
        $allHeaders = array_merge($this->headers, $headers);

        // Add signature authentication if guard is set
        if ($this->guard) {
            $authHeaders = $this->guard->generateHeaders($method, $uri, $body);
            $allHeaders = array_merge($allHeaders, $authHeaders);
        }

        // Initialize cURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

        // Set headers
        $headerStrings = [];
        foreach ($allHeaders as $key => $value) {
            $headerStrings[] = "{$key}: {$value}";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerStrings);

        // Set body for POST/PUT/PATCH
        if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH']) && $body) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Handle cURL error
        if ($error) {
            throw new \Exception("API request failed: {$error}");
        }

        // Parse JSON response
        $data = json_decode($response, true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Failed to parse API response: " . json_last_error_msg());
        }

        // Check for HTTP errors
        if ($httpCode >= 400) {
            $message = $data['message'] ?? $data['error'] ?? 'API request failed';
            throw new \Exception("{$message} (HTTP {$httpCode})");
        }

        return $data;
    }

    /**
     * Build full URL from URI
     *
     * @param string $uri
     * @return string
     */
    protected function buildUrl(string $uri): string
    {
        $uri = ltrim($uri, '/');
        $baseUrl = rtrim($this->baseUrl, '/');

        return "{$baseUrl}/{$uri}";
    }

    /**
     * Set base URL
     *
     * @param string $baseUrl
     * @return self
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * Get base URL
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Set API guard
     *
     * @param InternalApiGuard $guard
     * @return self
     */
    public function setGuard(InternalApiGuard $guard): self
    {
        $this->guard = $guard;
        return $this;
    }

    /**
     * Get API guard
     *
     * @return InternalApiGuard|null
     */
    public function getGuard(): ?InternalApiGuard
    {
        return $this->guard;
    }

    /**
     * Set header
     *
     * @param string $key
     * @param string $value
     * @return self
     */
    public function setHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Set headers
     *
     * @param array $headers
     * @return self
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    /**
     * Get headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set timeout
     *
     * @param int $timeout Timeout in seconds
     * @return self
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Get timeout
     *
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * Create from config with signature authentication
     *
     * @return self
     */
    public static function withSignature(): self
    {
        return new self(
            config('app.url'),
            InternalApiGuard::fromConfig()
        );
    }

    /**
     * Create from config without authentication
     *
     * @return self
     */
    public static function create(): self
    {
        return new self(config('app.url'));
    }
}
