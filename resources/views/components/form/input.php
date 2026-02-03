<?php
/**
 * Form Input Component
 *
 * A form input field with label, validation, and error display.
 *
 * Props:
 *   - name: string - Input name (required)
 *   - type: string - Input type (text|email|password|number|tel|url|date|datetime-local|time|color|file), default: 'text'
 *   - label: string|null - Label text
 *   - value: mixed - Input value
 *   - placeholder: string|null - Placeholder text
 *   - required: bool - Required field, default: false
 *   - disabled: bool - Disabled state, default: false
 *   - readonly: bool - Readonly state, default: false
 *   - error: string|null - Error message to display
 *   - help: string|null - Help text below input
 *   - class: string - Additional input CSS classes
 *   - wrapperClass: string - Wrapper CSS classes
 *   - id: string|null - Input ID (defaults to name)
 *   - autocomplete: string|null - Autocomplete attribute
 *   - autofocus: bool - Autofocus on load, default: false
 *   - min: mixed - Min value (for number/date)
 *   - max: mixed - Max value (for number/date)
 *   - step: mixed - Step value (for number)
 *   - pattern: string|null - Validation pattern
 *
 * Usage:
 *   <?= $view->component('form.input', [
 *       'name' => 'email',
 *       'type' => 'email',
 *       'label' => 'Email Address',
 *       'required' => true,
 *       'value' => old('email'),
 *       'error' => $errors['email'] ?? null
 *   ]) ?>
 */

$name = $name ?? '';
$type = $type ?? 'text';
$label = $label ?? null;
$value = $value ?? '';
$placeholder = $placeholder ?? '';
$required = $required ?? false;
$disabled = $disabled ?? false;
$readonly = $readonly ?? false;
$error = $error ?? null;
$help = $help ?? null;
$class = $class ?? '';
$wrapperClass = $wrapperClass ?? '';
$id = $id ?? $name;
$autocomplete = $autocomplete ?? null;
$autofocus = $autofocus ?? false;
$min = $min ?? null;
$max = $max ?? null;
$step = $step ?? null;
$pattern = $pattern ?? null;

// Use old() helper for form repopulation if available
if (function_exists('old') && empty($value)) {
    $value = old($name, $value);
}

// Build input classes
$inputClasses = ['form-control'];
if ($error) $inputClasses[] = 'is-invalid';
if ($class) $inputClasses[] = $class;

// Build attributes
$attrs = [];
$attrs[] = 'type="' . e($type) . '"';
$attrs[] = 'name="' . e($name) . '"';
$attrs[] = 'id="' . e($id) . '"';
$attrs[] = 'class="' . implode(' ', $inputClasses) . '"';

if ($value !== '' && $value !== null) {
    $attrs[] = 'value="' . e($value) . '"';
}
if ($placeholder) $attrs[] = 'placeholder="' . e($placeholder) . '"';
if ($required) $attrs[] = 'required';
if ($disabled) $attrs[] = 'disabled';
if ($readonly) $attrs[] = 'readonly';
if ($autofocus) $attrs[] = 'autofocus';
if ($autocomplete) $attrs[] = 'autocomplete="' . e($autocomplete) . '"';
if ($min !== null) $attrs[] = 'min="' . e($min) . '"';
if ($max !== null) $attrs[] = 'max="' . e($max) . '"';
if ($step !== null) $attrs[] = 'step="' . e($step) . '"';
if ($pattern) $attrs[] = 'pattern="' . e($pattern) . '"';

$attrString = implode(' ', $attrs);
?>

<div class="form-group <?= e($wrapperClass) ?>">
    <?php if ($label): ?>
        <label for="<?= e($id) ?>" class="form-label">
            <?= e($label) ?>
            <?php if ($required): ?>
                <span class="text-danger">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <input <?= $attrString ?>>

    <?php if ($error): ?>
        <div class="invalid-feedback">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($help && !$error): ?>
        <small class="form-text text-muted">
            <?= e($help) ?>
        </small>
    <?php endif; ?>
</div>
