<?php
/**
 * Card Component
 *
 * A flexible card container with optional header, footer, and body sections.
 *
 * Props:
 *   - title: string|null - Card title in header
 *   - subtitle: string|null - Card subtitle
 *   - class: string - Additional CSS classes
 *   - shadow: bool - Add shadow, default: true
 *   - bordered: bool - Add border, default: true
 *   - padding: bool - Add body padding, default: true
 *
 * Slots:
 *   - default: Card body content
 *   - header: Custom header content (overrides title/subtitle)
 *   - footer: Footer content
 *   - actions: Action buttons in header
 *
 * Usage:
 *   <?= $view->component('card', ['title' => 'Users'], '<p>Card body</p>') ?>
 *
 *   <?= $view->component('card', [
 *       'title' => 'Dashboard',
 *       'shadow' => true
 *   ], $content, [
 *       'footer' => '<button class="btn btn-primary">Save</button>',
 *       'actions' => '<button class="btn btn-sm">Refresh</button>'
 *   ]) ?>
 */

$title = $title ?? null;
$subtitle = $subtitle ?? null;
$class = $class ?? '';
$shadow = $shadow ?? true;
$bordered = $bordered ?? true;
$padding = $padding ?? true;

$cardClasses = ['card'];
if ($shadow) $cardClasses[] = 'card-shadow';
if ($bordered) $cardClasses[] = 'card-bordered';
if ($class) $cardClasses[] = $class;

$hasHeader = $__slot->has('header') || $title || $__slot->has('actions');
$hasFooter = $__slot->has('footer');
?>

<div class="<?= implode(' ', $cardClasses) ?>">
    <?php if ($hasHeader): ?>
        <div class="card-header">
            <?php if ($__slot->has('header')): ?>
                <?= $__slot->get('header') ?>
            <?php else: ?>
                <div class="card-header-content">
                    <?php if ($title): ?>
                        <h3 class="card-title"><?= e($title) ?></h3>
                    <?php endif; ?>
                    <?php if ($subtitle): ?>
                        <p class="card-subtitle"><?= e($subtitle) ?></p>
                    <?php endif; ?>
                </div>
                <?php if ($__slot->has('actions')): ?>
                    <div class="card-actions">
                        <?= $__slot->get('actions') ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="card-body<?= $padding ? '' : ' p-0' ?>">
        <?= $__slot ?>
    </div>

    <?php if ($hasFooter): ?>
        <div class="card-footer">
            <?= $__slot->get('footer') ?>
        </div>
    <?php endif; ?>
</div>
