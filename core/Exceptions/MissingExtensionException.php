<?php

namespace Core\Exceptions;

use RuntimeException;

/**
 * Missing Extension Exception
 *
 * Thrown when a required PHP extension is not loaded.
 * This exception helps developers quickly identify missing dependencies.
 */
class MissingExtensionException extends RuntimeException
{
    /**
     * Constructor
     *
     * @param string $extension Extension name (e.g., 'intl', 'pdo', 'mbstring')
     * @param string|null $context Additional context (e.g., 'CurrencyFormatter requires intl extension')
     */
    public function __construct(string $extension, ?string $context = null)
    {
        $message = sprintf(
            "Required PHP extension '%s' is not loaded.",
            $extension
        );

        if ($context) {
            $message .= " " . $context;
        }

        $message .= sprintf(
            "\n\nTo install on Ubuntu/Debian:\n  sudo apt-get install php%s-intl\n  sudo service apache2 restart (or php-fpm restart)",
            PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION
        );

        $message .= "\n\nTo verify installation:\n  php -m | grep intl";

        parent::__construct($message, 500);
    }

    /**
     * Get the missing extension name
     *
     * @return string Extension name
     */
    public function getExtension(): string
    {
        return 'intl';
    }
}
