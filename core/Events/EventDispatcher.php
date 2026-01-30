<?php

namespace Core\Events;

/**
 * Event Dispatcher
 *
 * Registers listeners and dispatches events.
 * Supports class-based listeners, closures, and wildcard patterns.
 *
 * Usage:
 *   $dispatcher->listen(UserRegistered::class, SendWelcomeEmail::class);
 *   $dispatcher->listen('user.*', AuditLogger::class);
 *   $dispatcher->dispatch(new UserRegistered($user));
 */
class EventDispatcher
{
    /**
     * Registered listeners: event name => [listeners]
     */
    protected array $listeners = [];

    /**
     * Wildcard listeners: pattern => [listeners]
     */
    protected array $wildcards = [];

    /**
     * Cached wildcard matches to avoid re-computing
     */
    protected array $wildcardCache = [];

    /**
     * Register a listener for an event
     *
     * @param string $event Event class name or string name (supports * wildcards)
     * @param string|callable $listener Listener class name or callable
     */
    public function listen(string $event, string|callable $listener): void
    {
        if (str_contains($event, '*')) {
            $this->wildcards[$event][] = $listener;
            $this->wildcardCache = []; // Invalidate cache
        } else {
            $this->listeners[$event][] = $listener;
        }
    }

    /**
     * Register a subscriber (class with a subscribe() method)
     *
     * @param string $subscriber Subscriber class name
     */
    public function subscribe(string $subscriber): void
    {
        $instance = new $subscriber();

        if (!method_exists($instance, 'subscribe')) {
            throw new \InvalidArgumentException("{$subscriber} must have a subscribe() method.");
        }

        $instance->subscribe($this);
    }

    /**
     * Dispatch an event to all registered listeners
     *
     * @param Event|string $event Event object or event name string
     * @param array $payload Additional data (when dispatching by string name)
     * @return array Listener return values
     */
    public function dispatch(Event|string $event, array $payload = []): array
    {
        $eventName = $event instanceof Event ? $event->eventName() : $event;
        $responses = [];

        $listeners = $this->getListeners($eventName);

        foreach ($listeners as $listener) {
            // Check propagation stop for Event objects
            if ($event instanceof Event && $event->isPropagationStopped()) {
                break;
            }

            $response = $this->callListener($listener, $event, $payload);
            $responses[] = $response;

            // If listener returns false, stop propagation
            if ($response === false) {
                break;
            }
        }

        return $responses;
    }

    /**
     * Check if an event has listeners
     */
    public function hasListeners(string $eventName): bool
    {
        return !empty($this->getListeners($eventName));
    }

    /**
     * Remove all listeners for an event
     */
    public function forget(string $event): void
    {
        if (str_contains($event, '*')) {
            unset($this->wildcards[$event]);
            $this->wildcardCache = [];
        } else {
            unset($this->listeners[$event]);
        }
    }

    /**
     * Remove all listeners
     */
    public function flush(): void
    {
        $this->listeners = [];
        $this->wildcards = [];
        $this->wildcardCache = [];
    }

    /**
     * Get all listeners for an event (including wildcard matches)
     */
    public function getListeners(string $eventName): array
    {
        $listeners = $this->listeners[$eventName] ?? [];

        // Add wildcard listeners
        $listeners = array_merge($listeners, $this->getWildcardListeners($eventName));

        return $listeners;
    }

    /**
     * Get wildcard listeners matching an event name
     */
    protected function getWildcardListeners(string $eventName): array
    {
        if (isset($this->wildcardCache[$eventName])) {
            return $this->wildcardCache[$eventName];
        }

        $matched = [];

        foreach ($this->wildcards as $pattern => $listeners) {
            if ($this->matchesWildcard($pattern, $eventName)) {
                $matched = array_merge($matched, $listeners);
            }
        }

        $this->wildcardCache[$eventName] = $matched;
        return $matched;
    }

    /**
     * Check if a pattern matches an event name
     */
    protected function matchesWildcard(string $pattern, string $eventName): bool
    {
        $regex = str_replace(
            ['\\*', '\\'],
            ['.*', '\\\\'],
            preg_quote($pattern, '/')
        );

        return (bool) preg_match('/^' . $regex . '$/i', $eventName);
    }

    /**
     * Call a listener with the event
     */
    protected function callListener(string|callable $listener, Event|string $event, array $payload): mixed
    {
        // Callable (closure or invokable)
        if (is_callable($listener)) {
            return $listener($event, $payload);
        }

        // Class-based listener — instantiate and call handle()
        if (is_string($listener) && class_exists($listener)) {
            $instance = new $listener();

            if (method_exists($instance, 'handle')) {
                return $instance->handle($event, $payload);
            }

            // If invokable
            if (is_callable($instance)) {
                return $instance($event, $payload);
            }

            throw new \RuntimeException("Listener {$listener} must have a handle() method or be invokable.");
        }

        throw new \InvalidArgumentException("Invalid listener: " . (is_string($listener) ? $listener : gettype($listener)));
    }
}
