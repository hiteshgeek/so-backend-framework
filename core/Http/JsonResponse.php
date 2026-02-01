<?php

namespace Core\Http;

/**
 * JSON Response
 */
class JsonResponse extends Response
{
    public function __construct(array $data, int $statusCode = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'application/json';
        $content = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        parent::__construct($content, $statusCode, $headers);
    }

    public static function success(mixed $data, ?string $message = null, int $code = 200): self
    {
        // Use translation if no message provided
        if ($message === null) {
            $message = function_exists('trans') ? trans('messages.success') : 'Success';
        }

        return new self([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error(?string $message = null, int $code = 400, array $errors = []): self
    {
        // Use translation if no message provided
        if ($message === null) {
            $message = function_exists('trans') ? trans('messages.error') : 'An error occurred.';
        }

        return new self([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    public static function created(mixed $data, ?string $message = null): self
    {
        // Use translation if no message provided
        if ($message === null) {
            $message = function_exists('trans') ? trans('messages.created') : 'Created successfully.';
        }

        return self::success($data, $message, 201);
    }

    public static function noContent(): self
    {
        return new self([], 204);
    }
}
