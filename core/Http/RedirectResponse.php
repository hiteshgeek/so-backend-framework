<?php

namespace Core\Http;

/**
 * Redirect Response
 */
class RedirectResponse extends Response
{
    public function __construct(string $url, int $statusCode = 302)
    {
        parent::__construct('', $statusCode, ['Location' => $url]);
    }

    public function with(string $key, mixed $value): self
    {
        session()->flash($key, $value);
        return $this;
    }

    public function withInput(array $input = []): self
    {
        session()->flashInput($input ?: request()->all());
        return $this;
    }

    public function withErrors(array $errors): self
    {
        session()->flash('errors', $errors);
        return $this;
    }
}
