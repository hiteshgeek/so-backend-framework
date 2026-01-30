<?php

namespace Core\Events;

/**
 * Base Event Class
 *
 * All application events should extend this class.
 *
 * Usage:
 *   class UserRegistered extends Event {
 *       public function __construct(public readonly User $user) {}
 *   }
 */
abstract class Event
{
    /**
     * Whether propagation of this event should be stopped
     */
    protected bool $propagationStopped = false;

    /**
     * Stop event propagation (remaining listeners won't be called)
     */
    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }

    /**
     * Check if propagation is stopped
     */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    /**
     * Get the event name (defaults to class name)
     */
    public function eventName(): string
    {
        return static::class;
    }
}
