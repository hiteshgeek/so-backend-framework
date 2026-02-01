<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * Key Generate Command
 *
 * Generates a secure application key for encryption
 *
 * Usage:
 *   php sixorbit key:generate
 *   php sixorbit key:generate --show
 *   php sixorbit key:generate --force
 */
class KeyGenerateCommand extends Command
{
    protected string $signature = 'key:generate {--show} {--force}';
    protected string $description = 'Generate APP_KEY for encryption';

    public function handle(): int
    {
        try {
            // Generate a secure random key
            $key = $this->generateKey();

            // If --show flag is set, just display the key
            if ($this->option('show', false)) {
                $this->info("Generated key: {$key}");
                $this->comment("Copy this key to your .env file as APP_KEY={$key}");
                return 0;
            }

            // Check if key already exists
            $envPath = base_path('.env');
            if (!file_exists($envPath)) {
                $this->error(".env file not found at: {$envPath}");
                $this->comment("Please create a .env file first.");
                return 1;
            }

            $envContent = file_get_contents($envPath);
            $currentKey = $this->getCurrentKey($envContent);

            // Warn if key already set (unless --force is used)
            if ($currentKey !== '' && !$this->option('force', false)) {
                $this->error("Application key already set!");
                $this->comment("Current key: {$currentKey}");
                $this->comment("Use --force to regenerate and overwrite the existing key.");
                $this->comment("WARNING: Regenerating the key will invalidate all encrypted data.");

                if (!$this->confirm("Do you want to regenerate the key?", false)) {
                    $this->comment("Operation cancelled.");
                    return 0;
                }
            }

            // Update .env file
            if (!$this->updateEnvFile($envPath, $envContent, $key)) {
                $this->error("Failed to update .env file.");
                return 1;
            }

            $this->info("Application key set successfully!");
            $this->info("New key: {$key}");

            if ($currentKey !== '') {
                $this->comment("Previous key: {$currentKey}");
                $this->comment("WARNING: All previously encrypted data will need to be re-encrypted.");
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("Error generating key: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Generate a secure random key
     *
     * @return string
     */
    protected function generateKey(): string
    {
        $randomBytes = random_bytes(32);
        return 'base64:' . base64_encode($randomBytes);
    }

    /**
     * Get the current key from .env content
     *
     * @param string $envContent
     * @return string
     */
    protected function getCurrentKey(string $envContent): string
    {
        if (preg_match('/^APP_KEY=(.*)$/m', $envContent, $matches)) {
            return trim($matches[1]);
        }
        return '';
    }

    /**
     * Update the .env file with the new key
     *
     * @param string $envPath
     * @param string $envContent
     * @param string $newKey
     * @return bool
     */
    protected function updateEnvFile(string $envPath, string $envContent, string $newKey): bool
    {
        // Check if APP_KEY line exists
        if (preg_match('/^APP_KEY=/m', $envContent)) {
            // Replace existing APP_KEY line
            $newContent = preg_replace('/^APP_KEY=.*$/m', "APP_KEY={$newKey}", $envContent);
        } else {
            // Add APP_KEY line
            $newContent = $envContent;
            if (!str_ends_with($newContent, "\n")) {
                $newContent .= "\n";
            }
            $newContent .= "APP_KEY={$newKey}\n";
        }

        return file_put_contents($envPath, $newContent) !== false;
    }
}
