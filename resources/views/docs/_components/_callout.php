<?php
/**
 * Callout Component
 *
 * Creates styled callout boxes for notes, warnings, tips, etc.
 *
 * Usage:
 *   <?= callout('info', 'This is an info message') ?>
 *   <?= callout('warning', 'Be careful!', 'Warning') ?>
 *   <?= callout('danger', 'This will delete everything', 'Danger Zone') ?>
 *   <?= callout('success', 'Operation completed') ?>
 *   <?= callout('tip', 'Pro tip: Use shortcuts') ?>
 *   <?= callout('note', 'Remember this') ?>
 */

/**
 * Render a callout box
 *
 * @param string $type    Type: info|warning|danger|success|tip|note
 * @param string $content Content text (can include HTML)
 * @param string|null $title Optional title
 * @param string|null $icon Optional custom icon (MDI icon name without 'mdi-' prefix)
 * @return string HTML output
 */
function callout(string $type, string $content, ?string $title = null, ?string $icon = null): string
{
    $icons = [
        'info' => 'information',
        'warning' => 'alert',
        'danger' => 'alert-circle',
        'success' => 'check-circle',
        'tip' => 'lightbulb-on',
        'note' => 'note-text',
    ];

    $defaultTitles = [
        'info' => 'Info',
        'warning' => 'Warning',
        'danger' => 'Danger',
        'success' => 'Success',
        'tip' => 'Tip',
        'note' => 'Note',
    ];

    $iconName = $icon ?? ($icons[$type] ?? 'information');
    $displayTitle = $title ?? ($defaultTitles[$type] ?? null);

    $titleHtml = $displayTitle
        ? '<div class="callout-title">' . htmlspecialchars($displayTitle) . '</div>'
        : '';

    return <<<HTML
<div class="callout callout-{$type}">
    <span class="mdi mdi-{$iconName} callout-icon"></span>
    <div class="callout-content">
        {$titleHtml}
        <div class="callout-text">{$content}</div>
    </div>
</div>
HTML;
}

/**
 * Shorthand functions for common callout types
 */
function calloutInfo(string $content, ?string $title = null): string
{
    return callout('info', $content, $title);
}

function calloutWarning(string $content, ?string $title = null): string
{
    return callout('warning', $content, $title);
}

function calloutDanger(string $content, ?string $title = null): string
{
    return callout('danger', $content, $title);
}

function calloutSuccess(string $content, ?string $title = null): string
{
    return callout('success', $content, $title);
}

function calloutTip(string $content, ?string $title = null): string
{
    return callout('tip', $content, $title);
}

function calloutNote(string $content, ?string $title = null): string
{
    return callout('note', $content, $title);
}
