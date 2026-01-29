<?php

namespace Core\Console;

/**
 * Console Kernel
 *
 * Registers and executes console commands
 */
class Kernel
{
    /**
     * Registered commands
     */
    protected array $commands = [];

    /**
     * Register a command
     */
    public function register(string $commandClass): void
    {
        $command = new $commandClass();

        if (!$command instanceof Command) {
            throw new \InvalidArgumentException("Command must extend Core\\Console\\Command");
        }

        $this->commands[$command->getName()] = $command;
    }

    /**
     * Register multiple commands
     */
    public function registerCommands(array $commandClasses): void
    {
        foreach ($commandClasses as $commandClass) {
            $this->register($commandClass);
        }
    }

    /**
     * Run a command
     */
    public function call(array $argv): int
    {
        if (count($argv) < 2) {
            $this->showHelp();
            return 0;
        }

        $commandName = $argv[1];

        if ($commandName === 'list' || $commandName === '--help' || $commandName === '-h') {
            $this->showHelp();
            return 0;
        }

        if (!isset($this->commands[$commandName])) {
            echo "Command not found: {$commandName}\n\n";
            $this->showHelp();
            return 1;
        }

        $command = $this->commands[$commandName];
        $command->parseInput($argv);

        try {
            return $command->handle();
        } catch (\Exception $e) {
            fwrite(STDERR, "Command failed: " . $e->getMessage() . "\n");
            fwrite(STDERR, $e->getTraceAsString() . "\n");
            return 1;
        }
    }

    /**
     * Show help/list of commands
     */
    protected function showHelp(): void
    {
        echo "SO Backend Framework - Artisan Console\n\n";
        echo "Usage:\n";
        echo "  php artisan <command> [options] [arguments]\n\n";
        echo "Available commands:\n";

        foreach ($this->commands as $name => $command) {
            $description = $command->getDescription();
            printf("  %-30s %s\n", $name, $description);
        }

        echo "\n";
    }

    /**
     * Get all registered commands
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
