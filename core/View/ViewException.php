<?php

namespace Core\View;

/**
 * View-specific exception with template context
 *
 * Provides rich error information including template name, path, line number,
 * and available view variables for debugging.
 */
class ViewException extends \Exception
{
    /**
     * Full path to the template file
     */
    protected string $templatePath;

    /**
     * Line number in the template where error occurred
     */
    protected int $templateLine;

    /**
     * Template name (dot notation)
     */
    protected string $templateName;

    /**
     * Data that was passed to the view
     */
    protected array $viewData;

    /**
     * Create a new ViewException
     *
     * @param string $message Error message
     * @param string $templatePath Full path to template file
     * @param int $templateLine Line number in template
     * @param string $templateName Template name (dot notation)
     * @param array $viewData View data for debugging
     * @param \Throwable|null $previous Previous exception
     */
    public function __construct(
        string $message,
        string $templatePath,
        int $templateLine,
        string $templateName,
        array $viewData = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);

        $this->templatePath = $templatePath;
        $this->templateLine = $templateLine;
        $this->templateName = $templateName;
        $this->viewData = $viewData;
    }

    /**
     * Get the template file path
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    /**
     * Get the template line number
     *
     * @return int
     */
    public function getTemplateLine(): int
    {
        return $this->templateLine;
    }

    /**
     * Get the template name
     *
     * @return string
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * Get the view data
     *
     * @return array
     */
    public function getViewData(): array
    {
        return $this->viewData;
    }

    /**
     * Create from a caught exception during view rendering
     *
     * @param \Throwable $e Original exception
     * @param string $templatePath Template file path
     * @param string $templateName Template name
     * @param array $data View data
     * @return self
     */
    public static function fromException(
        \Throwable $e,
        string $templatePath,
        string $templateName,
        array $data = []
    ): self {
        $line = $e->getLine();
        $message = $e->getMessage();

        // If the error occurred in the template file itself
        if ($e->getFile() === $templatePath) {
            return new self(
                $message,
                $templatePath,
                $line,
                $templateName,
                $data,
                $e
            );
        }

        // Error in included file or dependency
        $contextMessage = $message . ' (in ' . basename($e->getFile()) . ':' . $e->getLine() . ')';

        return new self(
            $contextMessage,
            $templatePath,
            0, // Unknown line in template
            $templateName,
            $data,
            $e
        );
    }

    /**
     * Get a formatted string representation of the error
     *
     * @return string
     */
    public function getFormattedError(): string
    {
        $output = "View Error: {$this->message}\n\n";
        $output .= "Template: {$this->templateName}\n";
        $output .= "File: {$this->templatePath}\n";

        if ($this->templateLine > 0) {
            $output .= "Line: {$this->templateLine}\n";
        }

        return $output;
    }
}
