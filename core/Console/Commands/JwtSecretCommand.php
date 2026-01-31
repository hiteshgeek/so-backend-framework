<?php

namespace Core\Console\Commands;

use Core\Console\Command;

/**
 * JWT Secret Command
 *
 * Generates a secure JWT secret key for token signing
 *
 * Usage:
 *   php sixorbit jwt:secret
 *   php sixorbit jwt:secret --show
 *   php sixorbit jwt:secret --force
 */
class JwtSecretCommand extends Command
{
    protected string $signature = 'jwt:secret {--show} {--force}';
    protected string $description = 'Generate JWT_SECRET';

    public function handle(): int
    {
        try {
            // Generate a secure random key
            $secret = $this->generateSecret();

            // If --show flag is set, just display the secret
            if ($this->option('show', false)) {
                $this->info("Generated secret: {$secret}");
                $this->comment("Copy this secret to your .env file as JWT_SECRET={$secret}");
                return 0;
            }

            // Check if .env file exists
            $envPath = base_path('.env');
            if (!file_exists($envPath)) {
                $this->error(".env file not found at: {$envPath}");
                $this->comment("Please create a .env file first.");
                return 1;
            }

            $envContent = file_get_contents($envPath);
            $currentSecret = $this->getCurrentSecret($envContent);

            // Warn if secret already set (unless --force is used)
            if ($currentSecret !== '' && !$this->option('force', false)) {
                $this->error("JWT secret already set!");
                $this->comment("Current secret: {$currentSecret}");
                $this->comment("Use --force to regenerate and overwrite the existing secret.");
                $this->comment("WARNING: Regenerating the secret will invalidate all existing JWT tokens.");

                if (!$this->confirm("Do you want to regenerate the secret?", false)) {
                    $this->comment("Operation cancelled.");
                    return 0;
                }
            }

            // Update .env file
            if (!$this->updateEnvFile($envPath, $envContent, $secret)) {
                $this->error("Failed to update .env file.");
                return 1;
            }

            $this->info("JWT secret set successfully!");
            $this->info("New secret: {$secret}");

            if ($currentSecret !== '') {
                $this->comment("Previous secret: {$currentSecret}");
                $this->comment("WARNING: All existing JWT tokens will be invalid and users will need to re-authenticate.");
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("Error generating JWT secret: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Generate a secure random secret
     *
     * @return string
     */
    protected function generateSecret(): string
    {
        $randomBytes = random_bytes(32);
        return base64_encode($randomBytes);
    }

    /**
     * Get the current secret from .env content
     *
     * @param string $envContent
     * @return string
     */
    protected function getCurrentSecret(string $envContent): string
    {
        if (preg_match('/^JWT_SECRET=(.*)$/m', $envContent, $matches)) {
            return trim($matches[1]);
        }
        return '';
    }

    /**
     * Update the .env file with the new secret
     *
     * @param string $envPath
     * @param string $envContent
     * @param string $newSecret
     * @return bool
     */
    protected function updateEnvFile(string $envPath, string $envContent, string $newSecret): bool
    {
        // Check if JWT_SECRET line exists
        if (preg_match('/^JWT_SECRET=/m', $envContent)) {
            // Replace existing JWT_SECRET line
            $newContent = preg_replace('/^JWT_SECRET=.*$/m', "JWT_SECRET={$newSecret}", $envContent);
        } else {
            // Add JWT_SECRET line
            $newContent = $envContent;
            if (!str_ends_with($newContent, "\n")) {
                $newContent .= "\n";
            }
            $newContent .= "JWT_SECRET={$newSecret}\n";
        }

        return file_put_contents($envPath, $newContent) !== false;
    }
}
