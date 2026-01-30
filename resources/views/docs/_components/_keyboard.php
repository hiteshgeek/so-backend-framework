<?php
/**
 * Keyboard Shortcut Component
 *
 * Displays keyboard shortcuts with styled key caps.
 *
 * Usage:
 *   <?= kbd('Ctrl') ?>
 *   <?= kbdCombo('Ctrl', 'C') ?>
 *   <?= kbdCombo('Ctrl', 'Shift', 'P') ?>
 */

/**
 * Render a single keyboard key
 *
 * @param string $key Key label
 * @return string HTML output
 */
function kbd(string $key): string
{
    return '<kbd class="kbd">' . htmlspecialchars($key) . '</kbd>';
}

/**
 * Render a keyboard shortcut combination
 *
 * @param string ...$keys Keys in the combination
 * @return string HTML output
 */
function kbdCombo(string ...$keys): string
{
    if (empty($keys)) {
        return '';
    }

    $keysHtml = array_map(fn($key) => kbd($key), $keys);

    return '<span class="kbd-combo">' .
        implode('<span class="kbd-separator">+</span>', $keysHtml) .
        '</span>';
}

/**
 * Render a keyboard shortcut from string notation
 *
 * @param string $shortcut Shortcut string (e.g., "Ctrl+Shift+P")
 * @return string HTML output
 */
function kbdFromString(string $shortcut): string
{
    $keys = array_map('trim', explode('+', $shortcut));
    return kbdCombo(...$keys);
}
