<?php

namespace Core\Http;

/**
 * HTTP Response
 */
class Response
{
    protected string $content;
    protected int $statusCode;
    protected array $headers;

    public function __construct(string $content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function send(): void
    {
        // Save session data before sending response (especially important for redirects)
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        echo $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public static function view(string $view, array $data = []): self
    {
        extract($data);
        ob_start();
        $viewPath = base_path("resources/views/{$view}.php");
        if (file_exists($viewPath)) {
            require $viewPath;
        }
        $content = ob_get_clean();
        return new self($content);
    }

    public static function json(array $data, int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status);
    }

    public static function redirect(string $url, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }
}
