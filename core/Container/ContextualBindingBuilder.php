<?php

namespace Core\Container;

use Closure;

/**
 * Contextual Binding Builder
 *
 * Provides a fluent interface for defining contextual bindings.
 * Contextual bindings allow different implementations to be injected
 * based on which class is being resolved.
 *
 * Usage:
 *   $container->when(ReportGenerator::class)
 *       ->needs(LoggerInterface::class)
 *       ->give(FileLogger::class);
 *
 *   // With closure
 *   $container->when(ReportGenerator::class)
 *       ->needs(LoggerInterface::class)
 *       ->give(function ($container) {
 *           return new FileLogger('/var/log/reports.log');
 *       });
 *
 *   // Multiple classes with same binding
 *   $container->when([ReportGenerator::class, DataExporter::class])
 *       ->needs(LoggerInterface::class)
 *       ->give(FileLogger::class);
 */
class ContextualBindingBuilder
{
    /**
     * The container instance
     *
     * @var Container
     */
    protected Container $container;

    /**
     * The concrete classes receiving the binding
     *
     * @var array
     */
    protected array $concretes;

    /**
     * The abstract type being resolved
     *
     * @var string
     */
    protected string $needs;

    /**
     * Create a new contextual binding builder
     *
     * @param Container $container
     * @param array $concretes
     */
    public function __construct(Container $container, array $concretes)
    {
        $this->container = $container;
        $this->concretes = $concretes;
    }

    /**
     * Define the abstract type that needs a contextual binding
     *
     * @param string $abstract The interface or class type that needs binding
     * @return self
     */
    public function needs(string $abstract): self
    {
        $this->needs = $abstract;

        return $this;
    }

    /**
     * Define the implementation for the contextual binding
     *
     * @param Closure|string $implementation The implementation to use
     * @return void
     */
    public function give(Closure|string $implementation): void
    {
        foreach ($this->concretes as $concrete) {
            $this->container->addContextualBinding($concrete, $this->needs, $implementation);
        }
    }

    /**
     * Define an implementation using a tagged set of services
     *
     * @param string $tag The tag name
     * @return void
     */
    public function giveTagged(string $tag): void
    {
        $this->give(function (Container $container) use ($tag) {
            return $container->tagged($tag);
        });
    }

    /**
     * Specify a configuration value to use
     *
     * @param string $key The config key
     * @param mixed $default The default value
     * @return void
     */
    public function giveConfig(string $key, mixed $default = null): void
    {
        $this->give(function () use ($key, $default) {
            return config($key, $default);
        });
    }
}
