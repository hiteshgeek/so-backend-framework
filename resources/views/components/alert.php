<?php
/**
 * Alert Component
 *
 * Displays an alert/notification message with different styles.
 *
 * Props:
 *   - type: string (success|warning|danger|info) - Alert type, default: 'info'
 *   - dismissible: bool - Show close button, default: false
 *   - title: string|null - Optional title text
 *   - icon: string|null - Optional icon class (e.g., 'fa fa-check')
 *
 * Slots:
 *   - default: Main alert content
 *   - icon: Custom icon content (overrides icon prop)
 *
 * Usage:
 *   <?= $view->component('alert', ['type' => 'success'], 'Operation completed!') ?>
 *
 *   <?= $view->component('alert', [
 *       'type' => 'warning',
 *       'title' => 'Warning',
 *       'dismissible' => true
 *   ], 'Please review your input.', [
 *       'icon' => '<i class="fa fa-exclamation-triangle"></i>'
 *   ]) ?>
 */

$type = $type ?? 'info';
$dismissible = $dismissible ?? false;
$title = $title ?? null;
$icon = $icon ?? null;

$typeClasses = [
    'success' => 'alert-success',
    'warning' => 'alert-warning',
    'danger' => 'alert-danger',
    'error' => 'alert-danger',
    'info' => 'alert-info',
];

$alertClass = $typeClasses[$type] ?? 'alert-info';

$defaultIcons = [
    'success' => 'check-circle',
    'warning' => 'exclamation-triangle',
    'danger' => 'times-circle',
    'error' => 'times-circle',
    'info' => 'info-circle',
];
?>

<div class="alert <?= $alertClass ?><?= $dismissible ? ' alert-dismissible' : '' ?>" role="alert">
    <?php if ($__slot->has('icon')): ?>
        <span class="alert-icon"><?= $__slot->get('icon') ?></span>
    <?php elseif ($icon): ?>
        <span class="alert-icon"><i class="<?= e($icon) ?>"></i></span>
    <?php endif; ?>

    <div class="alert-body">
        <?php if ($title): ?>
            <strong class="alert-title"><?= e($title) ?></strong>
        <?php endif; ?>

        <div class="alert-content">
            <?= $__slot ?>
        </div>
    </div>

    <?php if ($dismissible): ?>
        <button type="button" class="alert-close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    <?php endif; ?>
</div>
