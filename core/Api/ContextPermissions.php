<?php

namespace Core\Api;

/**
 * Context-based Permissions
 *
 * Manages permissions based on request context.
 * Different contexts have different allowed operations.
 *
 * Usage:
 *   $permissions = new ContextPermissions();
 *   if ($permissions->can($context, 'users.create')) {
 *       // Allow operation
 *   }
 */
class ContextPermissions
{
    /**
     * Permission definitions per context
     */
    protected array $permissions = [];

    /**
     * Constructor
     *
     * @param array|null $permissions Custom permissions (from config if not provided)
     */
    public function __construct(?array $permissions = null)
    {
        $this->permissions = $permissions ?? $this->getDefaultPermissions();
    }

    /**
     * Get default permissions per context
     *
     * @return array
     */
    protected function getDefaultPermissions(): array
    {
        return config('api.permissions', [
            // Web context - Full access to UI operations
            RequestContext::WEB => [
                'users.*',
                'posts.*',
                'comments.*',
                'settings.*',
                'dashboard.*',
            ],

            // Mobile context - Limited to mobile-specific operations
            RequestContext::MOBILE => [
                'users.read',
                'users.update',      // Own profile only
                'posts.read',
                'posts.create',
                'posts.update',      // Own posts only
                'posts.delete',      // Own posts only
                'comments.read',
                'comments.create',
                'comments.update',   // Own comments only
                'comments.delete',   // Own comments only
            ],

            // Cron context - System operations only
            RequestContext::CRON => [
                'system.*',
                'reports.generate',
                'cleanup.*',
                'notifications.send',
                'cache.clear',
                'sessions.cleanup',
            ],

            // External API context - Read-only by default
            RequestContext::EXTERNAL => [
                'users.read',
                'posts.read',
                'comments.read',
            ],
        ]);
    }

    /**
     * Check if context has permission
     *
     * @param string|RequestContext $context Context type or instance
     * @param string $permission Permission to check (e.g., 'users.create')
     * @return bool
     */
    public function can($context, string $permission): bool
    {
        // Convert RequestContext to string
        if ($context instanceof RequestContext) {
            $context = $context->getContext();
        }

        // Get permissions for context
        $contextPermissions = $this->permissions[$context] ?? [];

        // Check exact match
        if (in_array($permission, $contextPermissions)) {
            return true;
        }

        // Check wildcard permissions
        foreach ($contextPermissions as $allowed) {
            if ($this->matchesWildcard($permission, $allowed)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if permission matches wildcard pattern
     *
     * @param string $permission Permission to check
     * @param string $pattern Wildcard pattern (e.g., 'users.*')
     * @return bool
     */
    protected function matchesWildcard(string $permission, string $pattern): bool
    {
        // Exact match
        if ($permission === $pattern) {
            return true;
        }

        // Wildcard match (e.g., 'users.*' matches 'users.create')
        if (str_ends_with($pattern, '.*')) {
            $prefix = substr($pattern, 0, -2);
            return str_starts_with($permission, $prefix . '.');
        }

        // Full wildcard
        if ($pattern === '*') {
            return true;
        }

        return false;
    }

    /**
     * Check if context cannot perform operation
     *
     * @param string|RequestContext $context
     * @param string $permission
     * @return bool
     */
    public function cannot($context, string $permission): bool
    {
        return !$this->can($context, $permission);
    }

    /**
     * Get all permissions for context
     *
     * @param string|RequestContext $context
     * @return array
     */
    public function getPermissions($context): array
    {
        if ($context instanceof RequestContext) {
            $context = $context->getContext();
        }

        return $this->permissions[$context] ?? [];
    }

    /**
     * Set permissions for context
     *
     * @param string $context
     * @param array $permissions
     * @return self
     */
    public function setPermissions(string $context, array $permissions): self
    {
        $this->permissions[$context] = $permissions;
        return $this;
    }

    /**
     * Add permission to context
     *
     * @param string $context
     * @param string $permission
     * @return self
     */
    public function addPermission(string $context, string $permission): self
    {
        if (!isset($this->permissions[$context])) {
            $this->permissions[$context] = [];
        }

        if (!in_array($permission, $this->permissions[$context])) {
            $this->permissions[$context][] = $permission;
        }

        return $this;
    }

    /**
     * Remove permission from context
     *
     * @param string $context
     * @param string $permission
     * @return self
     */
    public function removePermission(string $context, string $permission): self
    {
        if (isset($this->permissions[$context])) {
            $this->permissions[$context] = array_filter(
                $this->permissions[$context],
                fn($p) => $p !== $permission
            );
        }

        return $this;
    }

    /**
     * Create from config
     *
     * @return self
     */
    public static function fromConfig(): self
    {
        return new self(config('api.permissions'));
    }
}
