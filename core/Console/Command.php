<?php

namespace Core\Console;

/**
 * Console Command Base Class
 *
 * Base class for all artisan commands
 */
abstract class Command
{
    /**
     * Command signature (e.g., "queue:work {--queue=default}")
     */
    protected string $signature = '';

    /**
     * Command description
     */
    protected string $description = '';

    /**
     * Command arguments
     */
    protected array $arguments = [];

    /**
     * Command options
     */
    protected array $options = [];

    /**
     * Execute the command
     */
    abstract public function handle(): int;

    /**
     * Get the command name from signature
     */
    public function getName(): string
    {
        $parts = explode(' ', $this->signature);
        return $parts[0] ?? '';
    }

    /**
     * Get the command description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Parse arguments and options from command line
     */
    public function parseInput(array $argv): void
    {
        // Remove script name and command name
        array_shift($argv); // script
        array_shift($argv); // command

        foreach ($argv as $arg) {
            if (str_starts_with($arg, '--')) {
                // Parse option
                $option = substr($arg, 2);
                if (str_contains($option, '=')) {
                    [$key, $value] = explode('=', $option, 2);
                    $this->options[$key] = $value;
                } else {
                    $this->options[$option] = true;
                }
            } else {
                // Parse argument
                $this->arguments[] = $arg;
            }
        }
    }

    /**
     * Get an argument by index
     */
    public function argument(int $index, $default = null)
    {
        return $this->arguments[$index] ?? $default;
    }

    /**
     * Get an option by name
     */
    public function option(string $name, $default = null)
    {
        return $this->options[$name] ?? $default;
    }

    /**
     * Write output to console
     */
    public function info(string $message): void
    {
        echo $message . "\n";
    }

    /**
     * Write error to console
     */
    public function error(string $message): void
    {
        fwrite(STDERR, "Error: " . $message . "\n");
    }

    /**
     * Write comment to console
     */
    public function comment(string $message): void
    {
        echo "# " . $message . "\n";
    }

    /**
     * Ask a question
     */
    public function ask(string $question, $default = null): string
    {
        echo $question;
        if ($default !== null) {
            echo " [{$default}]";
        }
        echo ": ";

        $handle = fopen("php://stdin", "r");
        $line = trim(fgets($handle));
        fclose($handle);

        return $line ?: ($default ?? '');
    }

    /**
     * Ask for confirmation
     */
    public function confirm(string $question, bool $default = false): bool
    {
        $defaultText = $default ? 'Y/n' : 'y/N';
        $answer = $this->ask("{$question} [{$defaultText}]");

        if (empty($answer)) {
            return $default;
        }

        return in_array(strtolower($answer), ['y', 'yes', '1', 'true']);
    }
}
