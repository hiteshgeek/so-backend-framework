<?php
/**
 * Button Component
 *
 * A flexible button with various styles and states.
 *
 * Props:
 *   - type: string - Button type (button|submit|reset), default: 'button'
 *   - variant: string - Style variant (primary|secondary|success|danger|warning|info|light|dark|link), default: 'primary'
 *   - size: string|null - Size (sm|md|lg), default: null (normal)
 *   - outline: bool - Outline style, default: false
 *   - disabled: bool - Disabled state, default: false
 *   - loading: bool - Loading state, default: false
 *   - block: bool - Full width, default: false
 *   - href: string|null - If set, renders as anchor tag
 *   - class: string - Additional CSS classes
 *   - icon: string|null - Icon class (e.g., 'fa fa-save')
 *   - iconPosition: string - Icon position (left|right), default: 'left'
 *
 * Slots:
 *   - default: Button label
 *   - icon: Custom icon content
 *
 * Usage:
 *   <?= $view->component('button', ['variant' => 'primary'], 'Save') ?>
 *
 *   <?= $view->component('button', [
 *       'variant' => 'success',
 *       'icon' => 'fa fa-check',
 *       'size' => 'lg'
 *   ], 'Submit') ?>
 */

$type = $type ?? 'button';
$variant = $variant ?? 'primary';
$size = $size ?? null;
$outline = $outline ?? false;
$disabled = $disabled ?? false;
$loading = $loading ?? false;
$block = $block ?? false;
$href = $href ?? null;
$class = $class ?? '';
$icon = $icon ?? null;
$iconPosition = $iconPosition ?? 'left';
$id = $id ?? null;
$name = $name ?? null;

// Build class list
$btnClasses = ['btn'];

// Variant
$variantClass = $outline ? "btn-outline-{$variant}" : "btn-{$variant}";
$btnClasses[] = $variantClass;

// Size
if ($size) {
    $btnClasses[] = "btn-{$size}";
}

// Block
if ($block) {
    $btnClasses[] = 'btn-block w-100';
}

// Loading
if ($loading) {
    $btnClasses[] = 'btn-loading';
    $disabled = true;
}

// Custom classes
if ($class) {
    $btnClasses[] = $class;
}

$classString = implode(' ', $btnClasses);

// Build attributes
$attrs = [];
if ($id) $attrs[] = 'id="' . e($id) . '"';
if ($name) $attrs[] = 'name="' . e($name) . '"';
if ($disabled) $attrs[] = 'disabled';

$attrString = $attrs ? ' ' . implode(' ', $attrs) : '';

// Icon rendering helper
$renderIcon = function() use ($__slot, $icon) {
    if ($__slot->has('icon')) {
        return $__slot->get('icon');
    }
    if ($icon) {
        return '<i class="' . e($icon) . '"></i>';
    }
    return '';
};

$iconHtml = $renderIcon();
$hasIcon = !empty(trim($iconHtml));
$hasLabel = $__slot->hasContent();
?>

<?php if ($href && !$disabled): ?>
    <a href="<?= e($href) ?>" class="<?= $classString ?>"<?= $attrString ?>>
        <?php if ($loading): ?>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <?php endif; ?>
        <?php if ($hasIcon && $iconPosition === 'left'): ?>
            <span class="btn-icon btn-icon-left"><?= $iconHtml ?></span>
        <?php endif; ?>
        <?php if ($hasLabel): ?>
            <span class="btn-label"><?= $__slot ?></span>
        <?php endif; ?>
        <?php if ($hasIcon && $iconPosition === 'right'): ?>
            <span class="btn-icon btn-icon-right"><?= $iconHtml ?></span>
        <?php endif; ?>
    </a>
<?php else: ?>
    <button type="<?= e($type) ?>" class="<?= $classString ?>"<?= $attrString ?>>
        <?php if ($loading): ?>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <?php endif; ?>
        <?php if ($hasIcon && $iconPosition === 'left'): ?>
            <span class="btn-icon btn-icon-left"><?= $iconHtml ?></span>
        <?php endif; ?>
        <?php if ($hasLabel): ?>
            <span class="btn-label"><?= $__slot ?></span>
        <?php endif; ?>
        <?php if ($hasIcon && $iconPosition === 'right'): ?>
            <span class="btn-icon btn-icon-right"><?= $iconHtml ?></span>
        <?php endif; ?>
    </button>
<?php endif; ?>
