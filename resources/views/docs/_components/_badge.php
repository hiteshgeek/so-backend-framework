<?php
/**
 * Badge Component
 *
 * Creates various styled badges and pills.
 *
 * Usage:
 *   <?= badge('New', 'new') ?>
 *   <?= badge('v2.0.0', 'version') ?>
 *   <?= httpBadge('GET') ?>
 *   <?= statusBadge('stable') ?>
 */

/**
 * Render a badge
 *
 * @param string $text Badge text
 * @param string $type Badge type (new, stable, beta, deprecated, experimental, version)
 * @param string|null $icon Optional icon name
 * @param string $size Size (sm, default, lg)
 * @return string HTML output
 */
function badge(string $text, string $type = 'default', ?string $icon = null, string $size = ''): string
{
    $sizeClass = $size ? " badge-{$size}" : '';
    $iconHtml = $icon ? '<span class="mdi mdi-' . htmlspecialchars($icon) . '"></span>' : '';

    return '<span class="badge badge-' . htmlspecialchars($type) . $sizeClass . '">' .
        $iconHtml .
        htmlspecialchars($text) .
        '</span>';
}

/**
 * Render an HTTP method badge
 *
 * @param string $method HTTP method (GET, POST, PUT, DELETE, PATCH)
 * @return string HTML output
 */
function httpBadge(string $method): string
{
    $method = strtoupper($method);
    $type = strtolower($method);

    return '<span class="badge badge-' . $type . '">' . $method . '</span>';
}

/**
 * Render a status badge
 *
 * @param string $status Status (stable, beta, deprecated, experimental, new)
 * @return string HTML output
 */
function statusBadge(string $status): string
{
    $status = strtolower($status);

    $icons = [
        'stable' => 'check-circle',
        'beta' => 'beta',
        'deprecated' => 'alert',
        'experimental' => 'flask',
        'new' => 'new-box',
    ];

    $icon = $icons[$status] ?? 'information';

    return '<span class="badge badge-' . $status . '">' .
        '<span class="mdi mdi-' . $icon . '"></span>' .
        ucfirst($status) .
        '</span>';
}

/**
 * Render a version badge
 *
 * @param string $version Version string (e.g., "v2.0.0")
 * @return string HTML output
 */
function versionBadge(string $version): string
{
    return '<span class="badge badge-version">' .
        '<span class="mdi mdi-tag"></span>' .
        htmlspecialchars($version) .
        '</span>';
}

/**
 * Render a required badge
 *
 * @return string HTML output
 */
function requiredBadge(): string
{
    return '<span class="badge badge-delete badge-sm">required</span>';
}

/**
 * Render an optional badge
 *
 * @return string HTML output
 */
function optionalBadge(): string
{
    return '<span class="badge badge-stable badge-sm">optional</span>';
}
