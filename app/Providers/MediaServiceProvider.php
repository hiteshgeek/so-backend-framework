<?php

namespace App\Providers;

use Core\Container\Container;
use Core\Media\StorageManager;
use Core\Media\FileValidator;
use Core\Media\FileUploadManager;
use Core\Image\ImageProcessor;
use Core\Image\WatermarkService;
use Core\Image\VariantGenerator;

/**
 * MediaServiceProvider
 *
 * Registers media and image processing services in the application container.
 *
 * Registered Services:
 * - StorageManager (singleton) - File storage operations
 * - FileValidator (singleton) - Upload validation
 * - FileUploadManager (singleton) - Upload orchestration
 * - ImageProcessor (factory) - Image manipulation (new instance per call)
 * - WatermarkService (singleton) - Watermark application
 * - VariantGenerator (singleton) - Image variant generation
 *
 * Usage:
 * ```php
 * $storage = app('storage');  // or app(StorageManager::class)
 * $uploader = app('uploader');
 * $processor = app(ImageProcessor::class);  // New instance
 * ```
 */
class MediaServiceProvider
{
    protected Container $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Register services in the container
     *
     * @return void
     */
    public function register(): void
    {
        // Register StorageManager as singleton
        $this->app->singleton('storage', function ($app) {
            return new StorageManager();
        });

        $this->app->singleton(StorageManager::class, function ($app) {
            return $app->make('storage');
        });

        // Register FileValidator as singleton
        $this->app->singleton('file.validator', function ($app) {
            return new FileValidator();
        });

        $this->app->singleton(FileValidator::class, function ($app) {
            return $app->make('file.validator');
        });

        // Register FileUploadManager as singleton
        $this->app->singleton('uploader', function ($app) {
            return new FileUploadManager();
        });

        $this->app->singleton(FileUploadManager::class, function ($app) {
            return $app->make('uploader');
        });

        // Register ImageProcessor as factory (new instance each time)
        $this->app->bind(ImageProcessor::class, function ($app) {
            return new ImageProcessor();
        });

        // Register WatermarkService as singleton
        $this->app->singleton('watermark', function ($app) {
            return new WatermarkService();
        });

        $this->app->singleton(WatermarkService::class, function ($app) {
            return $app->make('watermark');
        });

        // Register VariantGenerator as singleton
        $this->app->singleton('variant.generator', function ($app) {
            return new VariantGenerator();
        });

        $this->app->singleton(VariantGenerator::class, function ($app) {
            return $app->make('variant.generator');
        });
    }

    /**
     * Bootstrap services
     *
     * Called after all services are registered.
     *
     * @return void
     */
    public function boot(): void
    {
        // Ensure media directory exists
        $this->ensureMediaDirectoryExists();

        // Register validation rules
        $this->registerValidationRules();
    }

    /**
     * Ensure media storage directory exists
     *
     * @return void
     */
    protected function ensureMediaDirectoryExists(): void
    {
        $mediaPath = config('media.path', '/var/www/html/rpkfiles');

        if (!is_dir($mediaPath)) {
            mkdir($mediaPath, 0755, true);
        }
    }

    /**
     * Register custom validation rules for file uploads
     *
     * @return void
     */
    protected function registerValidationRules(): void
    {
        // You can register custom validation rules here
        // Example: Validator::extend('image_dimensions', ...)

        // For now, this is a placeholder for future custom rules
    }

    /**
     * Get services provided by this provider
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            'storage',
            'file.validator',
            'uploader',
            'watermark',
            'variant.generator',
            StorageManager::class,
            FileValidator::class,
            FileUploadManager::class,
            ImageProcessor::class,
            WatermarkService::class,
            VariantGenerator::class,
        ];
    }
}
