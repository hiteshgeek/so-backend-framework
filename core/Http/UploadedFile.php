<?php

namespace Core\Http;

/**
 * Uploaded File
 */
class UploadedFile
{
    protected array $file;

    public function __construct(array $file)
    {
        $this->file = $file;
    }

    public function isValid(): bool
    {
        return isset($this->file['error']) && $this->file['error'] === UPLOAD_ERR_OK;
    }

    public function getClientOriginalName(): string
    {
        return $this->file['name'] ?? '';
    }

    public function getSize(): int
    {
        return $this->file['size'] ?? 0;
    }

    public function getMimeType(): string
    {
        return $this->file['type'] ?? '';
    }

    public function getExtension(): string
    {
        return pathinfo($this->getClientOriginalName(), PATHINFO_EXTENSION);
    }

    public function move(string $directory, ?string $name = null): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        $name = $name ?? $this->getClientOriginalName();
        $destination = rtrim($directory, '/') . '/' . $name;

        return move_uploaded_file($this->file['tmp_name'], $destination);
    }
}
